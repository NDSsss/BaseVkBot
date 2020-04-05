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
            $table->bigIncrements('id')->unique();
            $table->integer('vk_user_id')->nullable()->unique();
            $table->string('name')->nullable();
            $table->string('city')->nullable();
            $table->string('coordinates')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('state')->default('main_screen');
            $table->unsignedBigInteger('random_id')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::dropIfExists('users_old');
//        Schema::create('users_old', function (Blueprint $table) {
//            $table->bigIncrements('id')->unique();
//            $table->integer('vk_user_id')->nullable()->unique();
//            $table->string('name')->nullable();
//            $table->string('city')->nullable();
//            $table->string('coordinates')->nullable();
//            $table->string('lat')->nullable();
//            $table->string('lng')->nullable();
//            $table->string('state')->default('main_screen');
//            $table->unsignedBigInteger('random_id')->default(1);
//        });
//        DB::table('users_old')->insert(DB::table('users')->get()->toArray());
        Schema::dropIfExists('users');
    }
}
