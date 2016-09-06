<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->boolean('has_full_access');
            $table->unsignedInteger('parent_id')->nullable();

            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('roles');
        });

        $this->populate();
    }

    /**
     * Reverse the migrations
     */
    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
        });

        Schema::drop('roles');
    }

    /**
     * Populate the table with required data
     */
    private function populate()
    {
        $data = require __DIR__ . '/data/roles.php';

        foreach($data as $datum){

            $datum['slug']       = str_slug($datum['name']);
            $datum['created_at'] = Carbon::now()->toDateTimeString();

            unset($datum['parent_name']);

            DB::table('roles')->insert($datum);
        }
    }
}
