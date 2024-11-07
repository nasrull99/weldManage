<?php

namespace Database\Factories;

use App\Models\Material;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaterialFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Material::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'material' => fake()->text(255),
            'price' => fake()->randomFloat(2, 0, 9999),
        ];
    }
}
