<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Address;
use App\Models\Country;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'country_id' => Country::factory(),
            'state_id' => State::factory(),
            'city_id' => City::factory(),
            'zip_code' => $this->faker->postcode(),
            'address' => $this->faker->address(),
        ];
    }
}
