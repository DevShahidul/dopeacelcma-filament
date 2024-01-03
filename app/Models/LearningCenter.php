<?php

namespace App\Models;

use App\Enum\Region;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
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

    public static function getForm(): array
    {
        return [
            TextInput::make('name')
                ->required()
                ->maxLength(255),
            Select::make('region')
                ->live()
                ->enum(Region::class)
                ->options(Region::class),
            Select::make('ngo_id')
                ->searchable()
                ->preload()
                ->relationship('ngo', 'name', modifyQueryUsing: function (Builder $query, Get $get){
                    return $query->where('region', $get('region'));
                })
                ->required(),
        ];
    }
}
