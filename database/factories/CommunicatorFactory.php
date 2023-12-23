<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Communicator;

class CommunicatorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Communicator::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'phone' => $this->faker->phoneNumber(),
            'facebook_url' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'whatsapp_number' => $this->faker->e164PhoneNumber(),
        ];
    }
}
