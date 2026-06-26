<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BatchResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'batch_number' => $this->batch_number,
            'quantity' => $this->quantity,
            'product_name' => $this->whenLoaded('product', fn() => $this->product->name),
            'warehouse_name' => $this->whenLoaded('warehouse', fn() => $this->warehouse->name),
            'display_label' => $this->whenLoaded('product', fn() => "{$this->batch_number} - {$this->product->name} ({$this->quantity} pcs)"),
        ];
    }
}
