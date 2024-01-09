<?php

namespace App\Models;

use Filament\Forms\Components\Section;
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

class Staff extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'country_id' => 'integer',
        'state_id' => 'integer',
        'city_id' => 'integer',
        'ngo_id' => 'integer',
        'designation_id' => 'integer',
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function designation(): BelongsTo
    {
        return $this->belongsTo(Designation::class);
    }

    public static function getForm(): array
    {
        return [
            Section::make('Staff Information')
            ->collapsible()
            ->icon('heroicon-s-academic-cap')
            ->columns(2)
            ->schema([
            Select::make('user_id')
                ->createOptionForm(User::getForm())
                ->editOptionForm(User::getForm())
                ->relationship('user', 'name')
                ->required(),
            Select::make('ngo_id')
                ->createOptionForm(Ngo::getForm())
                ->relationship('ngo', 'name')
                ->required(),
            Select::make('designation_id')
                ->createOptionForm(Designation::getForm())
                ->relationship('designation', 'name')
                ->required(),
            ]),
            Section::make('Staff Contacts')
                ->collapsible()
                ->icon('heroicon-s-flag')
                ->columns(2)
                ->schema([
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
                    TextInput::make('phone')
                        ->required(),
                    TextInput::make('facebook_url')
                        ->prefix('https://www.facebook.com/')
                        ->required(),
                    TextInput::make('whatsapp_number')
                        ->required(),
                ])
        ];
    }
}
