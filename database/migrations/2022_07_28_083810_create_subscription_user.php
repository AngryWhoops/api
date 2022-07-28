<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('subscription_user', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'subscription_id');
            $table->foreignIdFor(User::class, 'user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscription_user');
    }
};
