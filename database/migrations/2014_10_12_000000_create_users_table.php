<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nickname');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
            $table->boolean('superuser')->default(0);
            $table->string('first_name', 64)->default('');
            $table->string('last_name', 64)->default('');
            $table->string('sex', 200)->default('');
            $table->string('address', 200)->default('');
            $table->string('city', 200)->default('');
            $table->string('phone', 32)->default('');
            $table->string('session_token', 60)->default('');
            $table->boolean('active')->default(1);
            $table->string('user_session_token')->nullable();
            $table->dateTime('last_logged_in')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
