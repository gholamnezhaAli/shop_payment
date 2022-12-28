<?php

namespace Database\Factories;

use App\Models\Card;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CardFactory extends Factory
{
    protected $model = Card::class;

    public function definition()
    {
        return [
            'user_id' =>User::all()->random()->id,
            'card_number' => rand(1000000000000000, 9999999999999999),
            'cvv2' => rand(0000, 1111),
            'inventory' => $this->faker->numberBetween(20000000, 50000000),
        ];
    }
}
