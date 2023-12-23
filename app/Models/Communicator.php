<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Communicator extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'integer',
    ];

    public function communicable(): MorphTo
    {
        return $this->morphTo();
    }
}
