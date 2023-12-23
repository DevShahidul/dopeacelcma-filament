<?php

namespace Database\Factories;

use App\Models\Classes;
use App\Models\Section;
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
            'gender' => $this->faker->randomElement(["male","female","other"]),
            'birth_date' => $this->faker->date(),
            'age' => $this->faker->numberBetween(-10000, 10000),
            'email' => $this->faker->safeEmail(),
            'learning_center_id' => LearningCenter::factory(),
            'learning_center_type' => $this->faker->randomElement(["Coaching","Pre School"]),
            'classes_id' => Classes::factory(),
            'section_id' => Section::factory(),
            'class_roll' => $this->faker->regexify('[0-9]{20}'),
            'enroll_date' => $this->faker->date(),
            'is_still_in_learning_center' => $this->faker->boolean(),
            'graduated_date' => $this->faker->date(),
            'institute_name' => $this->faker->company(),
            'institute_class_roll' => $this->faker->regexify('[0-9]{20}'),
            'address_of_institute' => $this->faker->address(),
            'grade_of_students' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'department' => $this->faker->randomElement(["Science", "Arts", "Commerce"]),
        ];
    }
}
