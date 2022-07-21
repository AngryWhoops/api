<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Hashtag;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class HashtagFactory extends Factory
{
    protected $model = Hashtag::class;

    public function definition()
    {
        return [
            //
            'hashtag' => fake()->unique()->word()
        ];
    }
}
