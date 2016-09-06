<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('round_id');
            $table->unsignedInteger('archer_id');
            $table->unsignedInteger('scorer_id');

            $table->enum('bow_class', ['C', 'R', 'B', 'L', 'T']);
            $table->unsignedSmallInteger('hit_count');
            $table->unsignedSmallInteger('gold_count');
            $table->unsignedSmallInteger('total_score');

            $table->dateTime('shot_at');

            $table->timestamps();

            $table->foreign('round_id')->references('id')->on('rounds');
            $table->foreign('archer_id')->references('id')->on('users');
            $table->foreign('scorer_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations
     */
    public function down()
    {
        Schema::table('scores', function (Blueprint $table) {
            $table->dropForeign(['round_id']);
            $table->dropForeign(['archer_id']);
            $table->dropForeign(['scorer_id']);
        });

        Schema::drop('scores');
    }
}
