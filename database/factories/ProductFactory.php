<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $produtc = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function withFaker()
    {
        return \Faker\Factory::create('pt_BR');
    }

    public function definition()
    {
        return [
            'category_id' => 1,
            'name'        => $this->faker->unique()->word,
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 0, 100),
            'assessments_id' => 1
        ];
    }
}

