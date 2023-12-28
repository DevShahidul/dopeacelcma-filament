<?php

namespace App\Models;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'integer',
        'state_id' => 'integer',
    ];

    public static function getForm(): array
    {
        return [
            TextInput::make('name')
                ->label('City Name')
                ->label('City Name')
                ->required()
                ->maxLength(255),
            Select::make('state_id')
                ->createOptionForm(State::getForm())
                ->editOptionForm(State::getForm())
                ->relationship('state', 'name')
                ->required(),
        ];
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
