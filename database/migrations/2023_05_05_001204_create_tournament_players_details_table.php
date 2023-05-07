<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTournamentPlayersDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournament_players_details', function (Blueprint $table) {
            $table->id();
            $table->integer('tournament_id');
            $table->integer('player_id');
            $table->enum('files',[0,1])->default(0);
            $table->enum('paid',[0,1])->default(0);
            $table->enum('subscribe',[0,1])->default(0);
            $table->string('place')->nullable();
            $table->longText('notes')->nullable();



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
        Schema::dropIfExists('tournament_players_details');
    }
}
