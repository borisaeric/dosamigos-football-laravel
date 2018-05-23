<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStandingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('standings', function (Blueprint $table) {
            $table->integer('club_id')->unsigned()->nullable();
            $table->foreign('club_id')->references('id')->on('clubs')->onDelete('cascade');
            $table->integer('season_id')->unsigned()->nullable();
            $table->foreign('season_id')->references('id')->on('seasons')->onDelete('cascade');
            $table->integer('played_matches');            
            $table->integer('wins');
            $table->integer('draws');
            $table->integer('losses');
            $table->integer('goals_scored');
            $table->integer('goals_conceded');
            $table->integer('points');   

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
        Schema::dropIfExists('standings');
    }
}
