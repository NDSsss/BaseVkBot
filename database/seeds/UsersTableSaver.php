<?php


use Illuminate\Database\Schema\Blueprint;

class UsersTableSaver
{
    public static function CREATE_OLD_USERS_TABLE(){
        Schema::create('users_old', function (Blueprint $table) {
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
}
