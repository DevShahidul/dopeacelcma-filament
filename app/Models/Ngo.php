<?php

namespace App\Models;

use App\Enum\Region;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

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
            Select::make('country_id')
                ->live()
                ->searchable()
                ->preload()
                ->createOptionForm(Country::getForm())
                ->relationship('country', 'name')
                ->afterStateUpdated(function (Set $set){
                    $set('state_id', null);
                    $set('city_id', null);
                })
                ->required(),
            Select::make('state_id')
                ->live()
                ->searchable()
                ->preload()
                ->createOptionForm(State::getForm())
                ->editOptionForm(State::getForm())
                ->relationship('state', 'name', modifyQueryUsing: function (Builder $query, Get $get){
                    return $query->where('country_id', $get('country_id'));
                })
                ->afterStateUpdated(function (Set $set){
                    $set('city_id', null);
                })
                ->required(),
            Select::make('city_id')
                ->live()
                ->searchable()
                ->preload()
                ->createOptionForm(City::getForm())
                ->relationship('city', 'name', modifyQueryUsing: function (Builder $query, Get $get){
                    return $query->where('state_id', $get('state_id'));
                })
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
                ->sortable()
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
