<?php

namespace App\Models;

use App\Enum\Region;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Builder;
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
        'country_id' => 'integer',
        'state_id' => 'integer',
        'city_id' => 'integer',
        'ngo_id' => 'integer',
    ];

    public function ngo(): BelongsTo
    {
        return $this->belongsTo(Ngo::class);
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

    public static function getForm(): array
    {
        return [
            TextInput::make('name')
                ->required()
                ->maxLength(255),
            Select::make('ngo_id')
                ->searchable()
                ->preload()
                ->live()
                ->relationship('ngo', 'name')
                ->required(),
            Select::make('country_id')
                ->searchable()
                ->preload()
                ->live()
                ->relationship('country', 'name')
                ->createOptionForm(Country::getForm())
                ->afterStateUpdated(function (Set $set){
                    $set('state_id', null);
                    $set('city_id', null);
                })
                ->required(),
            Select::make('state_id')
                ->searchable()
                ->preload()
                ->live()
                ->relationship('state', 'name', modifyQueryUsing: function (Builder $query, Get $get){
                    return $query->where('country_id', $get('country_id'));
                })
                ->createOptionForm(State::getForm())
                ->afterStateUpdated(function (Set $set){
                    $set('city_id', null);
                })
                ->required(),
            Select::make('city_id')
                ->searchable()
                ->preload()
                ->live()
                ->relationship('city', 'name', modifyQueryUsing: function (Builder $query, Get $get){
                    return $query->where('state_id', $get('state_id'));
                })
                ->createOptionForm(City::getForm())
                ->required(),
            TextInput::make('zip_code')
                ->required(),
            TextInput::make('address')
                ->required(),
        ];
    }
}
