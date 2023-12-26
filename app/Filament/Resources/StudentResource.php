<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                TextInput::make('gender')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('birth_date')
                    ->required(),
                TextInput::make('age')
                    ->required()
                    ->numeric(),
                TextInput::make('email')
                    ->email()
                    ->maxLength(60),
                Forms\Components\Select::make('learning_center_id')
                    ->relationship('learningCenter', 'name')
                    ->required(),
                TextInput::make('learning_center_type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('classes_id')
                    ->relationship('classes', 'name')
                    ->required(),
                Forms\Components\Select::make('section_id')
                    ->relationship('section', 'id')
                    ->required(),
                TextInput::make('class_roll')
                    ->required()
                    ->maxLength(60),
                Forms\Components\DatePicker::make('enroll_date')
                    ->required(),
                Forms\Components\Toggle::make('is_still_in_learning_center')
                    ->required(),
                Forms\Components\DatePicker::make('graduated_date'),
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')
                    ->searchable(),
                TextColumn::make('last_name')
                    ->searchable(),
                TextColumn::make('fathers_name')
                    ->searchable(),
                TextColumn::make('mothers_name')
                    ->searchable(),
                TextColumn::make('gender')
                    ->searchable(),
                TextColumn::make('birth_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('age')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('learningCenter.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('learning_center_type')
                    ->searchable(),
                TextColumn::make('classes.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('section.id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('class_roll')
                    ->searchable(),
                TextColumn::make('enroll_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_still_in_learning_center')
                    ->boolean(),
                TextColumn::make('graduated_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('institute_name')
                    ->searchable(),
                TextColumn::make('institute_class_roll')
                    ->searchable(),
                TextColumn::make('address_of_institute')
                    ->searchable(),
                TextColumn::make('grade_of_students')
                    ->searchable(),
                TextColumn::make('department')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('deleted_at')
                    ->options([
                        'with-trashed' => 'With Trashed',
                        'only-trashed' => 'Only Trashed',
                    ])->query(function (Builder $query, array $data) {
                        $query->when($data['value'] === 'with-trashed', function (Builder $query){
                            $query->withTrashed();
                        })->when($data['value'] === 'only-trashed', function (Builder $query){
                            $query->onlyTrashed();
                        });
                    })
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
