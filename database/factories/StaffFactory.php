<?php

namespace Database\Factories;

use App\Models\Designation;
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
        ];
    }
}
