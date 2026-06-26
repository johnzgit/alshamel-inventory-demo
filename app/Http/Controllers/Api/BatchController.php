<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Batch;

class BatchController extends Controller
{
    public function index()
    {
        $batches = Batch::with(['product', 'warehouse'])->get();
        
        return response()->json([
            'data' => $batches->map(function ($batch) {
                return [
                    'id' => $batch->id,
                    'batch_number' => $batch->batch_number,
                    'quantity' => $batch->quantity,
                    'product_name' => $batch->product->name,
                    'warehouse_name' => $batch->warehouse->name,
                    'display_label' => "{$batch->batch_number} - {$batch->product->name} ({$batch->quantity} pcs)"
                ];
            })
        ]);
    }
}
