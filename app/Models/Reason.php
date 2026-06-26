<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\HasTranslations;

class Reason extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = ['type', 'code', 'description', 'is_active'];
    protected $translatable = ['description'];

    protected $casts = [
        'is_active' => 'boolean',
        'description' => 'array',
    ];
}
