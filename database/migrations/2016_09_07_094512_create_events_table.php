<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * CreateEventsTable
 *
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class CreateEventsTable extends Migration
{
    /**
     * Run the migrations
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('type_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('picture_url')->nullable();

            $table->dateTime('starts_at');
            $table->dateTime('ends_at')->nullable();
            $table->string('location_name');
            $table->decimal('location_latitude', 10, 6)->nullable();
            $table->decimal('location_longitude', 10, 6)->nullable();

            $table->unsignedTinyInteger('capacity');
            $table->boolean('has_waiting_list')->default(false);
            $table->enum('privacy', ['P', 'C', 'I'])->default('C'); # P: Public, C: Club, I: Invite-only
            $table->dateTime('cancelled_at')->nullable();

            $table->timestamps();

            $table->foreign('type_id')->references('id')->on('event_types');
        });
    }

    /**
     * Reverse the migrations
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['type_id']);
        });

        Schema::drop('events');
    }
}
