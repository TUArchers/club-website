<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('group');
            $table->string('description')->nullable();
        });

        $this->populate();
    }

    /**
     * Reverse the migrations
     */
    public function down()
    {
        Schema::drop('permissions');
    }

    /**
     * Populate the table with required data
     */
    private function populate()
    {
        $data = require __DIR__ . '/data/permissions.php';

        foreach($data as $datum){

            $datum['slug'] = str_slug($datum['name']);

            DB::table('permissions')->insert($datum);
        }
    }
}
