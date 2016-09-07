<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAttendeesTable extends Migration
{
    /**
     * Run the migrations
     */
    public function up()
    {
        Schema::create('attendees', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('event_id');
            $table->unsignedInteger('user_id')->nullable();

            $table->string('name');
            $table->string('email');
            $table->string('phone');

            $table->boolean('is_provisional')->default(true);
            $table->boolean('is_waiting')->default(false);

            $table->dateTime('registered_at');
            $table->dateTime('cancelled_at')->nullable();
            $table->dateTime('attended_at')->nullable();

            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations
     */
    public function down()
    {
        Schema::table('attendees', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::drop('attendees');
    }
}
