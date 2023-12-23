<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'integer',
        'student_id' => 'integer',
        'classes_id' => 'integer',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function classes(): BelongsTo
    {
        return $this->belongsTo(Classes::class);
    }
}
