<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use Filament\Tables\Filters\QueryBuilder\Constraints\BooleanConstraint;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StudentStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $activeStudents = BooleanConstraint::make('is_still_in_learning_center');
//        dd($activeStudents);
        return [
            Stat::make('Total students', Student::count()),
            Stat::make('Active students', 'a'),
            Stat::make('Average time on page', '3:12'),
        ];
    }
}
