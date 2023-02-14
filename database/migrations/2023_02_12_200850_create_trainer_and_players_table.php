<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainerAndPlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainer_and_players', function (Blueprint $table) {
            $table->id();
            $table->integer('trainer_id');
            $table->integer('player_id');
            $table->integer('sport_id');
            $table->timestamp('date_from');
            $table->timestamp('date_to');
            $table->timestamp('time_from');
            $table->timestamp('time_to');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trainer_and_players');
    }
}
