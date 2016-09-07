<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventTypesTable extends Migration
{
    /**
     * Run the migrations
     */
    public function up()
    {
        Schema::create('event_types', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('colour_hex')->default('7f8c8d');
            $table->string('icon_name')->default('icon-calendar');
        });

        $this->populate();
    }

    /**
     * Reverse the migrations
     */
    public function down()
    {
        Schema::drop('event_types');
    }

    /**
     * Populate the table with required data
     */
    private function populate()
    {
        $data = require __DIR__ . '/data/event_types.php';

        foreach($data as $datum){

            $datum['slug'] = str_slug($datum['name']);

            DB::table('event_types')->insert($datum);
        }
    }
}
