<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInventoryAdjustmentRequest;
use App\Http\Resources\InventoryAdjustmentResource;
use App\Models\Batch;
use App\Models\InventoryAdjustment;
use Illuminate\Support\Facades\DB;

class InventoryAdjustmentController extends Controller
{
    public function index()
    {
        $adjustments = InventoryAdjustment::with(['batch.product', 'batch.warehouse', 'reason'])
            ->orderBy('created_at', 'desc')
            ->get();
        return InventoryAdjustmentResource::collection($adjustments);
    }

    public function store(StoreInventoryAdjustmentRequest $request): InventoryAdjustmentResource
    {
        $adjustment = DB::transaction(function () use ($request) {
            // Pessimistic locking to prevent race conditions on stock update
            $batch = Batch::where('id', $request->batch_id)->lockForUpdate()->firstOrFail();
            
            $oldQuantity = $batch->quantity;
            $newQuantity = $request->new_quantity;
            $diffQuantity = $newQuantity - $oldQuantity;

            // Update batch quantity
            $batch->quantity = $newQuantity;
            $batch->save();

            // Create adjustment record
            return InventoryAdjustment::create([
                'batch_id' => $batch->id,
                'reason_id' => $request->reason_id,
                'old_quantity' => $oldQuantity,
                'new_quantity' => $newQuantity,
                'diff_quantity' => $diffQuantity,
                'note' => $request->note,
            ]);
        });

        $adjustment->load(['batch.product', 'batch.warehouse', 'reason']);

        return new InventoryAdjustmentResource($adjustment);
    }

    public function show(InventoryAdjustment $inventoryAdjustment): InventoryAdjustmentResource
    {
        $inventoryAdjustment->load(['batch.product', 'batch.warehouse', 'reason']);
        return new InventoryAdjustmentResource($inventoryAdjustment);
    }
}
