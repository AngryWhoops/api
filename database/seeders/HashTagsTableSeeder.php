<?php

namespace Database\Seeders;

use App\Models\Hashtag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HashTagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Hashtag::factory()->count(20)->create();
    }
}
