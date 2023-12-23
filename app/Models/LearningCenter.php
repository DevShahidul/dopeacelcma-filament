<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class LearningCenter extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'id' => 'integer',
        'ngo_id' => 'integer',
    ];

    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function ngo(): BelongsTo
    {
        return $this->belongsTo(Ngo::class);
    }
}
