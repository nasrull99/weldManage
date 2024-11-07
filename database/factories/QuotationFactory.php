<?php

namespace Database\Factories;

use App\Models\Quotation;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuotationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Quotation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cust_name' => fake()->text(255),
            'total_price' => fake()->randomNumber(1),
        ];
    }
}
