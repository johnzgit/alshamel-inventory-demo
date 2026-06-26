<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryAdjustmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'batch_id' => $this->batch_id,
            'reason_id' => $this->reason_id,
            'old_quantity' => $this->old_quantity,
            'new_quantity' => $this->new_quantity,
            'diff_quantity' => $this->diff_quantity,
            'note' => $this->note,
            'created_at' => $this->created_at,
            'batch' => [
                'batch_number' => $this->whenLoaded('batch')?->batch_number,
                'quantity' => $this->whenLoaded('batch')?->quantity,
                'product' => [
                    'name' => $this->whenLoaded('batch')?->product?->name,
                    'sku' => $this->whenLoaded('batch')?->product?->sku,
                ],
                'warehouse' => [
                    'name' => $this->whenLoaded('batch')?->warehouse?->name,
                ]
            ],
            'reason' => new ReasonResource($this->whenLoaded('reason')),
        ];
    }
}
