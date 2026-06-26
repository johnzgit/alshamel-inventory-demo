<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryAdjustment extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_id',
        'reason_id',
        'old_quantity',
        'new_quantity',
        'diff_quantity',
        'note',
    ];

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }

    public function reason(): BelongsTo
    {
        return $this->belongsTo(Reason::class);
    }
}
