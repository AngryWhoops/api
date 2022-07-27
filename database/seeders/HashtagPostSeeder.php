<?php

namespace Database\Seeders;

use App\Models\HashtagPost;
use Database\Factories\HashtagPostFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HashtagPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        HashtagPost::factory()->count(10)->create();
    }
}
