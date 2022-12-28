<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'user_id' => User::all()->random()->id,
            'name' => $this->faker->name(),
            'slug' => $this->faker->unique()->slug(),
            'description' => $this->faker->text(),
            'price' => $this->faker->numberBetween(1000000, 2000000),
            'quantity' => $this->faker->numberBetween(10, 20),
        ];
    }
}
