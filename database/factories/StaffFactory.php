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
            'user_id' => User::all()->random()->id,
            'ngo_id' => Ngo::all()->random()->id,
            'designation_id' => Designation::all()->random()->id,
            'country_id' => Country::all()->random()->id,
            'state_id' => State::all()->random()->id,
            'city_id' => City::all()->random()->id,
            'zip_code' => $this->faker->postcode(),
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
            'facebook_url' => $this->faker->url(),
            'whatsapp_number' => $this->faker->e164PhoneNumber(),
        ];
    }
}
