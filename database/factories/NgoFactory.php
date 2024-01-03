<?php

namespace Database\Factories;

use App\Enum\Region;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Ngo;

class NgoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ngo::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'region' => $this->faker->randomElement(Region::class),
            'country_id' => Country::factory(),
            'state_id' => State::factory(),
            'city_id' => City::factory(),
            'zip_code' => $this->faker->postcode(),
            'address' => $this->faker->address(),
        ];
    }
}
