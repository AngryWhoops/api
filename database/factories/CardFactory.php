<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Card;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Card>
 */
class CardFactory extends Factory
{
    protected $model = Card::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     public function definition()
    {
        return [
            'title' => $this->faker->name,
            'body' => $this->faker->text()
        ];
    }
}
