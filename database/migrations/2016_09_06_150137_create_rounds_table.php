<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use TuaWebsite\Domain\Identity\Organisation;
use TuaWebsite\Domain\Records\Season;

class CreateRoundsTable extends Migration
{
    /**
     * Run the migrations
     */
    public function up()
    {
        Schema::create('rounds', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->unique();
            $table->enum('organisation', Organisation::keys());
            $table->enum('season', Season::keys());

            $table->unsignedSmallInteger('total_targets')->default(1);
            $table->unsignedSmallInteger('total_shots');
            $table->unsignedSmallInteger('max_score');
            $table->unsignedSmallInteger('max_shot_score');
            $table->unsignedSmallInteger('min_shot_score');

            $table->timestamps();
        });

        $this->populate();
    }

    /**
     * Reverse the migrations
     */
    public function down()
    {
        Schema::drop('rounds');
    }

    /**
     * Populate the table with required data
     */
    private function populate()
    {
        $data = require __DIR__ . '/data/rounds.php';

        foreach($data as $datum){

            $datum['max_score']  = $datum['total_shots'] * $datum['max_shot_score'];
            $datum['created_at'] = Carbon::now()->toDateTimeString();

            DB::table('rounds')->insert($datum);
        }
    }
}
