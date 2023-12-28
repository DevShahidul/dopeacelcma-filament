<?php

namespace App\Filament\Resources;

use App\Enum\Gender;
use App\Enum\LearningCenterType;
use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Classes;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
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
            ->schema(Student::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->filtersTriggerAction(function ($action){
                return $action->button()->label('Filters');
            })
            ->columns([
                TextColumn::make('first_name')
                    ->searchable(),
                TextColumn::make('last_name')
                    ->searchable(),
                ImageColumn::make('avatar')
                    ->circular()
                    ->defaultImageUrl(function ($record) {
                        $name = "{$record->first_name} {$record->last_name}";
                        return 'https://ui-avatars.com/api/?background=0D8ABC&color=fff&name=' . urlencode($name);
                    }),
                TextColumn::make('fathers_name')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('mothers_name')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('gender')
                    ->searchable(),
                TextColumn::make('birth_date')
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('age')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('email')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('learningCenter.name')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('learning_center_type')
                    ->searchable(),
                TextColumn::make('classes.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('session.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('class_roll')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('enroll_date')
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_still_in_learning_center')
                    ->boolean(),
                TextColumn::make('graduated_date')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->date()
                    ->sortable(),
                TextColumn::make('institute_name')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('institute_class_roll')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('address_of_institute')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('grade_of_students')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('department')
                    ->toggleable(isToggledHiddenByDefault: true)
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
                TrashedFilter::make(),
                SelectFilter::make('learning_center_type')
                    ->options(LearningCenterType::class),
                SelectFilter::make('gender')
                    ->options(Gender::class)

            ])
            ->actions([
//                ViewAction::make(),
                ActionGroup::make([
                    EditAction::make()
                        ->slideOver(),
                    DeleteAction::make(),
                    ForceDeleteAction::make(),
                    RestoreAction::make(),
                ])
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->headerActions([
                Tables\Actions\Action::make('export')
                    ->tooltip('This will export all records visible in the table. Adjust filters to export a subset of records.')
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Personal Information')
                    ->collapsible()
                    ->icon('heroicon-s-academic-cap')
                    ->columns(3)
                ->schema([
                    ImageEntry::make('avatar')
                        ->circular()
                        ->defaultImageUrl(function ($record) {
                            $name = "{$record->first_name} {$record->last_name}";
                            return 'https://ui-avatars.com/api/?background=0D8ABC&color=fff&name=' . urlencode($name);
                        }),
                    Group::make()
                        ->columnSpan(2)
                        ->columns(2)
                        ->schema([
                            TextEntry::make('first_name'),
                            TextEntry::make('last_name'),
                            TextEntry::make('fathers_name'),
                            TextEntry::make('mothers_name'),
                        ]),
                    TextEntry::make('gender'),
                    TextEntry::make('birth_date'),
                    TextEntry::make('age'),
                ]),
                Section::make('Academic Information ')
                    ->collapsible()
                    ->icon('heroicon-s-building-library')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('learningCenter.name'),
                        TextEntry::make('classes.name'),
                        TextEntry::make('session.name'),
                        TextEntry::make('class_roll'),
                        TextEntry::make('enroll_date')
                            ->date(),

                        Fieldset::make('Current Institute Info')
                            ->hidden(fn($record): bool => $record->is_still_in_learning_center)
                            ->columns(3)
                            ->schema([
                                TextEntry::make('graduated_date')
                                    ->date(),
                                TextEntry::make('institute_name'),
                                TextEntry::make('institute_class_roll'),
                                TextEntry::make('address_of_institute'),
                                TextEntry::make('grade_of_students'),
                                TextEntry::make('department'),
                            ]),

                    ])
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
//            'edit' => Pages\EditStudent::route('/{record}/edit'),
            'view' => Pages\ViewStudent::route('/{record}'),
        ];
    }
}
