<?php

use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        //Посты с отметками пользователя
        Schema::create('post_user', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Post::class, 'post_id')->index();
            $table->foreignIdFor(User::class, 'user_id')->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_user');
    }
};
