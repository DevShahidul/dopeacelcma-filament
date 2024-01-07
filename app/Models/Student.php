<?php

namespace App\Models;

use App\Enum\Gender;
use Closure;
use App\Enum\LearningCenterType;
use Carbon\Carbon;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Student extends Model implements HasMedia
{
    use HasFactory, SoftDeletes;
    use InteractsWithMedia;

    public ?string $age = '';

    protected $casts = [
        'id' => 'integer',
        'birth_date' => 'date',
        'country_id' => 'integer',
        'state_id' => 'integer',
        'city_id' => 'integer',
        'learning_center_id' => 'integer',
        'learning_center_type' => LearningCenterType::class,
        'classes_id' => 'integer',
        'session_id' => 'integer',
        'enroll_date' => 'date',
        'is_still_in_learning_center' => 'boolean',
        'graduated_date' => 'date',
    ];

    public function learningCenter(): BelongsTo
    {
        return $this->belongsTo(LearningCenter::class);
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

    public function classes(): BelongsTo
    {
        return $this->belongsTo(Classes::class);
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(Session::class);
    }

    public function age(): Attribute
    {
        return Attribute::make(
            fn() => Carbon::parse($this->birth_date)->age,
        );
    }

    public static function getForm(): array
    {
        return [
            Section::make('Student Information')
                ->collapsible()
                ->icon('heroicon-s-academic-cap')
                ->columns(2)
                ->schema([
                    FileUpload::make('avatar')
                        ->avatar()
                        ->image()
                        ->directory('avatars')
                        ->preserveFilenames()
                        ->imageEditor()
                        ->maxSize(1024 * 1024 * 10),
                    TextInput::make('first_name')
                        ->required()
                        ->maxLength(60),
                    TextInput::make('last_name')
                        ->required()
                        ->maxLength(60),
                    TextInput::make('fathers_name')
                        ->required()
                        ->maxLength(60),
                    TextInput::make('mothers_name')
                        ->required()
                        ->maxLength(60),
                    TextInput::make('email')
                        ->email()
                        ->maxLength(60),
                    Select::make('gender')
                        ->live()
                        ->enum(Gender::class)
                        ->options(Gender::class)
                        ->required(),
                    DatePicker::make('birth_date')
                        ->native(false)
                        ->required(),
                ]),
            Section::make('Contact Information')
                ->collapsible()
                ->icon('heroicon-s-flag')
                ->columns(2)
                ->schema([
                    Select::make('country_id')
                        ->searchable()
                        ->preload()
                        ->live()
                        ->createOptionForm(Country::getForm())
                        ->editOptionForm(Country::getForm())
                        ->relationship('country', 'name')
                        ->afterStateUpdated(function (Set $set) {
                            $set('state_id', null);
                            $set('city_id', null);
                            $set('learning_center_id', null);
                        })
                        ->required(),
                    Select::make('state_id')
                        ->label('State')
                        ->options(fn(Get $get): Collection => State::query()
                            ->where('country_id', $get('country_id'))
                            ->pluck('name', 'id'))
                        ->searchable()
                        ->preload()
                        ->live()
                        ->createOptionForm(State::getForm())
                        ->afterStateUpdated(fn(Set $set) => $set('city_id', null))
                        ->required(),
                    Select::make('city_id')
                        ->label('City')
                        ->options(fn(Get $get): Collection => City::query()
                            ->where('state_id', $get('state_id'))
                            ->pluck('name', 'id'))
                        ->searchable()
                        ->preload()
                        ->live()
                        ->createOptionForm(City::getForm())
                        ->required(),
                    TextInput::make('zip_code')
                        ->required(),
                    TextInput::make('address')
                        ->required(),
                    TextInput::make('phone')
                        ->required(),
                    TextInput::make('facebook_url'),
                    TextInput::make('whatsapp_number'),
                ]),
            Section::make('Academic Information')
                ->collapsible()
                ->icon('heroicon-s-building-library')
                ->columns(2)
                ->schema([
                Select::make('learning_center_id')
                    ->label('Learning Center')
                    ->options(fn(Get $get): Collection => LearningCenter::query()
                        ->where('country_id', $get('country_id'))
                        ->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->createOptionForm(LearningCenter::getForm())
                    ->live()
                    ->required(),
                Select::make('learning_center_type')
                    ->live()
                    ->enum(LearningCenterType::class)
                    ->options(LearningCenterType::class),
                Select::make('classes_id')
                    ->searchable()
                    ->preload()
                    ->createOptionForm(Classes::getForm())
                    ->editOptionForm(Classes::getForm())
                    ->relationship('classes', 'name')
                    ->required(),
                Select::make('session_id')
                    ->relationship('session', 'name')
                    ->required(),
                TextInput::make('class_roll')
                    ->required()
                    ->maxLength(60),
                DatePicker::make('enroll_date')
                    ->native(false)
                    ->required(),
                Toggle::make('is_still_in_learning_center')
                    ->live()
                    ->required(),
                Fieldset::make('Current Institute Info')
                    ->hidden(
                        fn(Get $get) => $get('is_still_in_learning_center')
                    )
                    ->schema([
                        DatePicker::make('graduated_date')
                            ->native(false),
                        TextInput::make('institute_name')
                            ->maxLength(255),
                        TextInput::make('institute_class_roll')
                            ->maxLength(255),
                        TextInput::make('address_of_institute')
                            ->maxLength(255),
                        TextInput::make('grade_of_students')

                            ->maxLength(255),
                        TextInput::make('department')
                            ->maxLength(255),
                    ])
            ]),
            Actions::make([
                Action::make('star')
                    ->label('Fill with Factory Data')
                    ->icon('heroicon-m-document-text')
                    ->visible(function (string $operation){
                        if($operation !== 'create'){
                            return false;
                        }
                        if(! app()->environment('local')){
                            return false;
                        }
                        return true;
                    })
                    ->action(function ($livewire){
                        $data = Student::factory()->make()->toArray();
//                        unset($data['learning_center_id']);
                        $livewire->form->fill($data);
                    }),
            ]),
        ];
    }
}
