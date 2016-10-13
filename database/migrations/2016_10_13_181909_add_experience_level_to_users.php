<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Add Experience Level To Users
 *
 * @author  James Drew <jdrew9@hotmail.co.uk>
 * @version 0.1.0
 * @since   0.1.0
 */
class AddExperienceLevelToUsers extends Migration
{
    /**
     * Run the migrations
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table){
            $table->enum('experience_level', ['B', 'N', 'E'])->default('B');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table){
            $table->dropColumn('experience_level');
        });
    }
}
