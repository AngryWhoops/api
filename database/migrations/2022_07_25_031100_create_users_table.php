<?php

use App\Models\Post;
use App\Models\User;
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
            $table->foreignIdFor(User::class, 'user_id')->nullable()->default(1);
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
