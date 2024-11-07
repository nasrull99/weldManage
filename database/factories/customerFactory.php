<?php

namespace Database\Factories;

use App\Models\customer;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class customerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = customer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'location' => fake()->text(255),
            'status' => fake()->word(),
        ];
    }
}
