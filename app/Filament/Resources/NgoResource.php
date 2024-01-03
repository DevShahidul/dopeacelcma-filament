<?php

namespace App\Filament\Resources;

use App\Enum\Region;
use App\Filament\Resources\NgoResource\Pages;
use App\Filament\Resources\NgoResource\RelationManagers;
use App\Filament\Resources\NgoResource\RelationManagers\AddressRelationManager;
use App\Models\Ngo;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NgoResource extends Resource
{
    protected static ?string $model = Ngo::class;

    protected static ?string $navigationGroup = 'Ngos & Learning Centers';
//    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(Ngo::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(Ngo::getTableColumns())
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
            AddressRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNgos::route('/'),
            'create' => Pages\CreateNgo::route('/create'),
            'edit' => Pages\EditNgo::route('/{record}/edit'),
        ];
    }
}
