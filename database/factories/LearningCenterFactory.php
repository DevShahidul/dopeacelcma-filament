<?php

namespace Database\Factories;

use App\Enum\Region;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\LearningCenter;
use App\Models\Ngo;

class LearningCenterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LearningCenter::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name() . "Learning Center",
            'region' => $this->faker->randomElement(Region::class),
            'ngo_id' => Ngo::factory(),
            'country_id' => Country::all()->random()->id,
            'state_id' => State::all()->random()->id,
            'city_id' => City::all()->random()->id,
            'zip_code' => $this->faker->postcode(),
            'address' => $this->faker->address(),
        ];
    }
}
