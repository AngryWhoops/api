<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    public function definition()
    {
        return [
            //
            'body' => fake()->text(),
            'created_at' => fake()->date(),
            'updated_at' => fake()->date(),
            'user_id' => fake()->numberBetween(1, 5),
        ];
    }
}
