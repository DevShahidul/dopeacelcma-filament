<?php

namespace App\Filament\Resources;

use App\Enum\Region;
use App\Filament\Resources\LearningCenterResource\Pages;
use App\Filament\Resources\LearningCenterResource\RelationManagers;
use App\Filament\Resources\NgoResource\RelationManagers\AddressRelationManager;
use App\Models\LearningCenter;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LearningCenterResource extends Resource
{
    protected static ?string $model = LearningCenter::class;

    protected static ?string $navigationGroup = 'Ngos & Learning Centers';
//    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(LearningCenter::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('region')
                    ->searchable(),
                TextColumn::make('ngo.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('city.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('state.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('country.name')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
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
//            AddressRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLearningCenters::route('/'),
            'create' => Pages\CreateLearningCenter::route('/create'),
            'edit' => Pages\EditLearningCenter::route('/{record}/edit'),
        ];
    }
}
