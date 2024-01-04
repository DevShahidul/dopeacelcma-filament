<?php

namespace App\Models;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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
