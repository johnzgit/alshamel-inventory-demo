<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\HasTranslations;

class Product extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = ['name', 'sku'];
    protected $translatable = ['name'];

    protected $casts = [
        'name' => 'array',
    ];

    public function batches(): HasMany
    {
        return $this->hasMany(Batch::class);
    }
}
