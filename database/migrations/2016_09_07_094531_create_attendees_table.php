<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Create Attendees Table
 *
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class CreateAttendeesTable extends Migration
{
    /**
     * Run the migrations
     */
    public function up()
    {
        Schema::create('attendees', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('user_id')->nullable();

            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email_address');
            $table->string('phone_number');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations
     */
    public function down()
    {
        Schema::table('attendees', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::drop('attendees');
    }
}
