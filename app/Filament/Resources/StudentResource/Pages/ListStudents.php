<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use App\Filament\Widgets\StudentStatsWidget;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            StudentStatsWidget::class
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Students'),
            'still_in_learning_center' => Tab::make('Still in Learning Center')
                ->modifyQueryUsing( function ($query){
                    return $query->where('is_still_in_learning_center', true);
                }),
            'not_in_learning_center' => Tab::make('Not in the Learning Center')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('is_still_in_learning_center', false);
                }),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
