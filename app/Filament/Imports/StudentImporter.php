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
            ImportColumn::make('ngo')
                ->label('Student Profile: NGO Name')
                ->guess(['Student Profile: NGO Name', 'NGO name', 'ngo', 'Name of NGO'])
                ->relationship(resolveUsing: 'name'),
            ImportColumn::make('student_name_mentioned_year')
                ->integer(),
            ImportColumn::make('learningCenter')
                ->label('Student Profile: Learning Center Name')
                ->guess(['Student Profile: Learning Center Name', 'learning_center', 'Learning Center', 'learningCenter'])
                ->relationship(resolveUsing: 'name'),
            ImportColumn::make('first_name')
                ->label('Student First Name')
                ->guess(['Student First Name', 'first_name'])
                ->requiredMapping()
                ->rules(['required', 'max:60']),
            ImportColumn::make('last_name')
                ->label('Student Profile: Last Name')
                ->guess(['Student Profile: Last Name', 'last_name', 'Student Last Name'])
                ->requiredMapping()
                ->rules(['required', 'max:60']),
            ImportColumn::make('father_mother_name')
                ->label('Student Profile: Father/Mother Name')
                ->guess(['Student Profile: Father/Mother Name', 'father_mother_name', 'Fathers and Mothers Name'])
                ->requiredMapping()
                ->rules(['required', 'max:60']),
            ImportColumn::make('learning_center_type')
                ->label('Pre or coaching student')
                ->guess(['Pre or coaching student', 'learning_center_type'])
            ->fillRecordUsing(function (Student $record, string $state): void {
                $sanitizeState = str_replace('-', $state);
                $record->learning_center_type = strtolower($sanitizeState);
            }),
            ImportColumn::make('date_of_enrollment')
                ->label('Date of Enrollment (DD/MM/YY)')
                ->guess(['Date of Enrollment (DD/MM/YY). Example: 01 Jan, 2015 = 01/01/2015', 'Date of Enrollment', 'Date of Enrollment (DD/MM/YY)', 'date_of_enrollment', 'Enrollment Date']),
            ImportColumn::make('date_of_graduation')
                ->label('Date of Graduation (DD/MM/YY)')
                ->guess(['Date of Graduation (DD/MM/YY). Example: 30 Dec, 2016 = 30/12/2016', 'Date of Graduation (DD/MM/YY)', 'date_of_graduation', 'Graduation Date']),
            ImportColumn::make('date_of_birth')
                ->label('Student\'s date of birth (DD/MM/YY)')
                ->guess(["Student's date of birth (DD/MM/YY). Example: 25 Dec, 2011 = 25/12/2011", "date_of_birth", "Date of Birth"])
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('age')
                ->label('Age')
                ->guess(['Age (4 years 6 months to 5 and half years)', 'Age']),
            ImportColumn::make('gender')
                ->label('Indicate the gender of the child(M-Male/F-Female)')
                ->guess(['Indicate the gender of the child (M-Male/F-Female)', 'Indicate the gender of the child(M-Male/F-Female)', 'Gender', 'gender', 'Indicate the gender'])
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('phone')
                ->label('Telephone Number')
                ->guess(['Telephone Number', 'phone', 'Phone Number']),
            ImportColumn::make('is_still_in_learning_center')
                ->label('Is the student still in school')
                ->guess(['Is the student still in school in 2022', 'Is the student still in school', 'is_still_in_learning_center']),
            ImportColumn::make('grade_of_studying')
                ->label('Student: In which Grade is he/she is studying')
                ->guess(['Student: In which Grade is he/she is studying', 'grade_of_studying', 'Grade of Studying']),
            ImportColumn::make('current_institute_name')
                ->label('The name of the current school')
                ->guess(['The name of the current school', 'current_institute_name', 'Current Institute Name']),
            ImportColumn::make('city')
                ->label('City of the school')
                ->guess(['City of the school'])
                ->relationship(resolveUsing: 'name'),
            ImportColumn::make('current_institute_class_roll')
                ->label('Student: Class roll Number in current academic year')
                ->guess(['Student: Class roll Number in current academic year', 'current_institute_class_roll', 'Current Institute Class Roll', 'Institute Class Roll']),
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
