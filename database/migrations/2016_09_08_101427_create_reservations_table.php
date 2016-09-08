<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Create Reservations Table
 *
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('event_id');
            $table->unsignedInteger('attendee_id')->nullable();

            $table->dateTime('expires_at')->nullable();
            $table->dateTime('confirmed_at')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->dateTime('used_at')->nullable();

            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('attendee_id')->references('id')->on('attendees');
        });
    }

    /**
     * Reverse the migrations
     */
    public function down()
    {
        Schema::drop('reservations');
    }
}
