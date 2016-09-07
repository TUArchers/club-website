<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('event_id');
            $table->unsignedInteger('attendee_id');

            $table->boolean('is_reserve')->default(false);
            $table->dateTime('attended_at')->nullable();

            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('attendee_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
            $table->dropForeign(['attendee_id']);
        });

        Schema::drop('bookings');
    }
}
