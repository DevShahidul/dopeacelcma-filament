<?php

namespace Database\Factories;

use App\Models\Classes;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Attendance;
use App\Models\Student;

class AttendanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Attendance::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'classes_id' => Classes::factory(),
            'status' => $this->faker->randomElement(["Absent","Present","Late"]),
        ];
    }
}
