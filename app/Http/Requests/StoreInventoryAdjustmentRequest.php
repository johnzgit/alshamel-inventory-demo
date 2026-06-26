<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInventoryAdjustmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'batch_id' => ['required', 'integer', 'exists:batches,id'],
            'reason_id' => [
                'required', 
                'integer', 
                Rule::exists('reasons', 'id')->where(function ($query) {
                    return $query->where('is_active', true)
                                 ->where('type', 'inventory_adjustment');
                }),
            ],
            'new_quantity' => ['required', 'integer', 'min:0'],
            'note' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'reason_id.exists' => 'The selected reason is invalid, inactive, or not applicable for inventory adjustments.',
        ];
    }
}
