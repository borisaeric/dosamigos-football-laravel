<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('season_id')->unsigned()->nullable();
            $table->foreign('season_id')->references('id')->on('seasons')->onDelete('cascade');
            $table->integer('home_club_id')->unsigned()->nullable();
            $table->foreign('home_club_id')->references('id')->on('clubs')->onDelete('cascade');
            $table->integer('away_club_id')->unsigned()->nullable();
            $table->foreign('away_club_id')->references('id')->on('clubs')->onDelete('cascade');
            $table->integer('home_club_score')->unsigned()->nullable();
            $table->integer('away_club_score')->unsigned()->nullable();
            
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
        Schema::dropIfExists('matches');
    }
}
