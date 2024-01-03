<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Country;
use App\Models\Designation;
use App\Models\State;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Ngo;
use App\Models\Staff;

class StaffFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Staff::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'ngo_id' => Ngo::factory(),
            'designation_id' => Designation::factory(),
            'country_id' => Country::factory(),
            'state_id' => State::factory(),
            'city_id' => City::factory(),
            'zip_code' => $this->faker->postcode(),
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
            'facebook_url' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'whatsapp_number' => $this->faker->e164PhoneNumber(),
        ];
    }
}
