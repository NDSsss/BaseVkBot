<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePossibleStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('possible_states', function (Blueprint $table) {
            $table->unsignedBigInteger('current_state_id');
            $table->unsignedBigInteger('possible_state_id');

            $table->foreign('current_state_id')->references('id')->on('states');
            $table->foreign('possible_state_id')->references('id')->on('states');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('possible_states');
    }
}
