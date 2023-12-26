<?php

namespace App\Filament\Resources\LearningCenterResource\Pages;

use App\Filament\Resources\LearningCenterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLearningCenter extends EditRecord
{
    protected static string $resource = LearningCenterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
