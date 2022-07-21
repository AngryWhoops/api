<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hashtag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /* Hashtag::factory()->count(20)->create(); */

        $this->call(HashtagSeeder::class);
        $this->call(PostSeeder::class);
        $this->call(UserSeeder::class);
    }
}
