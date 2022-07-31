<?php

use App\Models\Hashtag;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id()->index();
            $table->timestamps();
            $table->text('body', 280)->nullable();
            $table->foreignIdFor(User::class, 'user_id')->default(1);
            $table->foreignIdFor(User::class, 'subscribed_user_id')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
