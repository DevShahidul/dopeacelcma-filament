<?php

namespace Database\Factories;

use App\Enum\Gender;
use App\Enum\LearningCenterType;
use App\Models\City;
use App\Models\Classes;
use App\Models\Country;
use App\Models\Ngo;
use App\Models\Session;
use App\Models\State;
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
            'father_mother_name' => $this->faker->name('male'),
            'gender' => $this->faker->randomElement(Gender::class),
            'date_of_birth' => $this->faker->date(),
            'zip_code' => $this->faker->postcode(),
            'address' => $this->faker->address(),
            'email' => $this->faker->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'facebook_url' => $this->faker->randomElement(['https://www.facebook.com', null]),
            'whatsapp_number' => $this->faker->e164PhoneNumber(),
            'ngo_id' => fn () => Ngo::all()->random()->id,
            'learning_center_id' => fn () => LearningCenter::count() > 0 ? LearningCenter::all()->random()->id : null,
            'learning_center_type' => $this->faker->randomElement(LearningCenterType::class),
            'student_name_mentioned_year' => $this->faker->year(),
            'classes_id' => fn () => Classes::count() > 0 ? Classes::all()->random()->id : null,
            'session_id' => fn () => Session::count() > 0 ? Session::all()->random()->id : null,
            'class_roll' => $this->faker->numberBetween(1, 120),
            'date_of_enrollment' => $this->faker->date(),
            'is_still_in_learning_center' => $this->faker->boolean(),
            'date_of_graduation' => $this->faker->date(),
            'current_institute_name' => $this->faker->company(),
            'current_institute_class_roll' => $this->faker->numberBetween(1, 120),
            'city_id' => City::all()->random()->id,
            'address_of_institute' => $this->faker->address(),
            'grade_of_studying' => $this->faker->randomElement(['One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven',
                'Eight', 'Nine', 'Ten', 'Eleven']),
            'department' => $this->faker->randomElement(["Science", "Arts", "Commerce"]),
        ];
    }
}
