<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class StudentsChart extends ChartWidget
{
    protected static ?string $heading = 'Students Chart';
    protected static ?int $sort = 3;


    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Students enrolled',
                    'data' => [0, 5, 2, 7, 9, 3, 108]
                ]
            ],
            'labels' => ['2010, 2011, 2012, 2013', '2014', '2015', '2016']
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    private function getStudentsPerYear(): array
    {
        $now = Carbon::now();

        $studentsPerYear = [];

//        $years = collect(range())
    }
}
