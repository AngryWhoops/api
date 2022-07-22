<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        //
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('login')->unique()->index();
            $table->string('subscriptions')->nullable();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id()->index();
            $table->timestamps();
            $table->string('body', 280);
        });

        Schema::create('hashtags', function (Blueprint $table) {
            $table->id();
            $table->string('hashtag')->unique()->index();
        });
    }


    public function down()
    {
        //
    }
};
