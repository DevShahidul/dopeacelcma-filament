<?php

namespace App\Filament\Imports;

use App\Models\Student;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class StudentImporter extends Importer
{
    protected static ?string $model = Student::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('avatar'),
            ImportColumn::make('first_name')
                ->requiredMapping()
                ->rules(['required', 'max:60']),
            ImportColumn::make('last_name')
                ->requiredMapping()
                ->rules(['required', 'max:60']),
            ImportColumn::make('fathers_name')
                ->requiredMapping()
                ->rules(['required', 'max:60']),
            ImportColumn::make('mothers_name')
                ->requiredMapping()
                ->rules(['required', 'max:60']),
            ImportColumn::make('email')
                ->rules(['max:60']),
            ImportColumn::make('gender')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('birth_date')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('country_id')
                ->relationship(),
            ImportColumn::make('country_id')
                ->relationship(),
            ImportColumn::make('country_id')
                ->relationship(),
        ];
    }

    public function resolveRecord(): ?Student
    {
        // return Student::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Student();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your student import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
