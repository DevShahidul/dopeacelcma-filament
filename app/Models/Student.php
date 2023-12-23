<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'id' => 'integer',
        'birth_date' => 'date',
        'learning_center_id' => 'integer',
        'classes_id' => 'integer',
        'section_id' => 'integer',
        'enroll_date' => 'date',
        'is_still_in_learning_center' => 'boolean',
        'graduated_date' => 'date',
    ];

    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function communicators(): MorphMany
    {
        return $this->morphMany(Communicator::class, 'communicatorable');
    }

    public function learningCenter(): BelongsTo
    {
        return $this->belongsTo(LearningCenter::class);
    }

    public function classes(): BelongsTo
    {
        return $this->belongsTo(Classes::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
}
