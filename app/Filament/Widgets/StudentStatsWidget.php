<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use Filament\Tables\Filters\QueryBuilder\Constraints\BooleanConstraint;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StudentStatsWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '3600s';
    protected function getStats(): array
    {
        $activeStudents = BooleanConstraint::make('is_still_in_learning_center');
//        dd($activeStudents);
        return [
            Stat::make('Total students', Student::count())->icon('heroicon-o-user-group'),
            Stat::make('Still in Learning Center', Student::query()->where('is_still_in_learning_center', true)->count()),
            Stat::make('Not in the Learning Center', Student::query()->where('is_still_in_learning_center', false)->count()),
        ];
    }
}
