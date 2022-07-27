<?php

use App\Models\Post;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('login')->unique()->default('MyUser');
            /* $table->foreignIdFor(Post::class, 'post_id')->nullable(); */
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
