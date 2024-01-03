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

    public function address(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function communicators(): MorphMany
    {
        return $this->morphMany(Communicator::class, 'communicatorable');
    }


    public function learningCenter(): BelongsTo
    {
        return $this->belongsTo(LearningCenter::class);
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
                        ->enum(Gender::class)
                        ->options(Gender::class)
                        ->required(),
                    DatePicker::make('birth_date')
                        ->native(false)
                        ->required(),
                ]),
            Section::make('Academic Information')
                ->collapsible()
                ->icon('heroicon-s-building-library')
                ->columns(2)
                ->schema([
                Select::make('learning_center_id')
                    ->searchable()
                    ->preload()
                    ->createOptionForm(LearningCenter::getForm())
                    ->editOptionForm(LearningCenter::getForm())
                    ->relationship('learningCenter', 'name')
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
                        fn(Get $get): bool => $get('is_still_in_learning_center')
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
