<?php

namespace Database\Factories;

use App\Enum\Gender;
use App\Models\Classes;
use App\Models\Session;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\LearningCenter;
use App\Models\Student;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'fathers_name' => $this->faker->name('male'),
            'mothers_name' => $this->faker->name('female'),
            'gender' => $this->faker->randomElement(Gender::class),
            'birth_date' => $this->faker->date(),
            'email' => $this->faker->safeEmail(),
            'learning_center_id' => LearningCenter::factory(),
            'learning_center_type' => $this->faker->randomElement(["Coaching","Pre School"]),
            'classes_id' => Classes::factory(),
            'session_id' => Session::factory(),
            'class_roll' => $this->faker->numberBetween(1, 120),
            'enroll_date' => $this->faker->date(),
            'is_still_in_learning_center' => $this->faker->boolean(),
            'graduated_date' => $this->faker->date(),
            'institute_name' => $this->faker->company(),
            'institute_class_roll' => $this->faker->numberBetween(1, 120),
            'address_of_institute' => $this->faker->address(),
            'grade_of_students' => $this->faker->randomElement(['One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven',
                'Eight', 'Nine', 'Ten', 'Eleven']),
            'department' => $this->faker->randomElement(["Science", "Arts", "Commerce"]),
        ];
    }
}
