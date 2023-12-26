<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
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
                Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->maxLength(60),
                Forms\Components\TextInput::make('last_name')
                    ->required()
                    ->maxLength(60),
                Forms\Components\TextInput::make('fathers_name')
                    ->required()
                    ->maxLength(60),
                Forms\Components\TextInput::make('mothers_name')
                    ->required()
                    ->maxLength(60),
                Forms\Components\TextInput::make('gender')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('birth_date')
                    ->required(),
                Forms\Components\TextInput::make('age')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(60),
                Forms\Components\Select::make('learning_center_id')
                    ->relationship('learningCenter', 'name')
                    ->required(),
                Forms\Components\TextInput::make('learning_center_type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('classes_id')
                    ->relationship('classes', 'name')
                    ->required(),
                Forms\Components\Select::make('section_id')
                    ->relationship('section', 'id')
                    ->required(),
                Forms\Components\TextInput::make('class_roll')
                    ->required()
                    ->maxLength(60),
                Forms\Components\DatePicker::make('enroll_date')
                    ->required(),
                Forms\Components\Toggle::make('is_still_in_learning_center')
                    ->required(),
                Forms\Components\DatePicker::make('graduated_date'),
                Forms\Components\TextInput::make('institute_name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('institute_class_roll')
                    ->maxLength(255),
                Forms\Components\TextInput::make('address_of_institute')
                    ->maxLength(255),
                Forms\Components\TextInput::make('grade_of_students')
                    ->maxLength(255),
                Forms\Components\TextInput::make('department')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fathers_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mothers_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender')
                    ->searchable(),
                Tables\Columns\TextColumn::make('birth_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('age')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('learningCenter.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('learning_center_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('classes.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('section.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('class_roll')
                    ->searchable(),
                Tables\Columns\TextColumn::make('enroll_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_still_in_learning_center')
                    ->boolean(),
                Tables\Columns\TextColumn::make('graduated_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('institute_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('institute_class_roll')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address_of_institute')
                    ->searchable(),
                Tables\Columns\TextColumn::make('grade_of_students')
                    ->searchable(),
                Tables\Columns\TextColumn::make('department')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
