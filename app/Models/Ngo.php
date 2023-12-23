<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ngo extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'id' => 'integer',
    ];

    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function learningCenters(): HasMany
    {
        return $this->hasMany(LearningCenter::class);
    }
}
