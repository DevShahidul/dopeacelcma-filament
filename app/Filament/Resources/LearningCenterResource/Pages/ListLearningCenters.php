<?php

namespace App\Filament\Resources\LearningCenterResource\Pages;

use App\Filament\Resources\LearningCenterResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLearningCenters extends ListRecords
{
    protected static string $resource = LearningCenterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
