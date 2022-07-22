<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            /* $table->unsignedBigInteger('posts_id')->nullable();
            $table->foreign('posts_id')->references('id')->on('posts')->onDelete('cascade'); */
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->string('user_author')->default('MyUser');
            $table->foreign('user_author')->references('login')->on('users');
            /* $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users'); */
            /* $table->unsignedBigInteger('hashtag_id')->nullable();
            $table->foreign('hashtag_id')->references('id')->on('hashtags'); */
        });

        Schema::table('hashtags', function (Blueprint $table) {
        });

        /* Schema::table('post_hashtag', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id')->index();
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->unsignedBigInteger('hashtag_id')->index();
            $table->foreign('hashtag_id')->references('id')->on('hashtags');
        }); */
    }

    public function down()
    {
        //
    }
};
