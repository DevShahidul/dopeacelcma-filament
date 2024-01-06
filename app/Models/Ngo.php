<?php

namespace App\Models;

use App\Enum\Region;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ngo extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'id' => 'integer',
        'country_id' => 'integer',
        'state_id' => 'integer',
        'city_id' => 'integer',
        'region' => Region::class,
    ];

    public function learningCenters(): HasMany
    {
        return $this->hasMany(LearningCenter::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public static function getForm(): array {
        return [
            TextInput::make('name')
                ->label('Ngo Name')
                ->required()
                ->maxLength(255),
            Select::make('region')
                ->enum(Region::class)
                ->options(Region::class)
                ->required(),
            Select::make('country_id')
                ->createOptionForm(Country::getForm())
                ->editOptionForm(Country::getForm())
                ->relationship('country', 'name')
                ->searchable()
                ->preload()
                ->required(),
            Select::make('state_id')
                ->createOptionForm(State::getForm())
                ->editOptionForm(State::getForm())
                ->relationship('state', 'name')
                ->searchable()
                ->preload()
                ->required(),
            Select::make('city_id')
                ->createOptionForm(City::getForm())
                ->editOptionForm(City::getForm())
                ->relationship('city', 'name')
                ->searchable()
                ->preload()
                ->required(),
            TextInput::make('zip_code')
                ->required(),
            TextInput::make('address')
                ->required(),
        ];
    }

    public static function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->searchable(),
            TextColumn::make('region')
                ->searchable(),
            TextColumn::make('city.name')
                ->sortable()
                ->searchable(),
            TextColumn::make('state.name')
                ->sortable()
                ->searchable(),
            TextColumn::make('country.name')
                ->sortable()
                ->searchable(),
        ];
    }
}
