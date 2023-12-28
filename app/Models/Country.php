<?php

namespace App\Models;

use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'integer',
    ];

    public static function getForm(): array
    {
        return [
            TextInput::make('name')
                ->label('Country name')
                ->required()
                ->maxLength(60),
            TextInput::make('code')
                ->required()
                ->maxLength(3),
            TextInput::make('phone_code')
                ->tel()
                ->maxLength(5),
        ];
    }

    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }
}
