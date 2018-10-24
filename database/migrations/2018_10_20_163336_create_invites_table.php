<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invites', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('email');
            $table->string('token');
            $table->unsignedTinyInteger('uses');
            $table->unsignedTinyInteger('uses_remaining');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('event_invite', function(Blueprint $table){
            $table->unsignedInteger('event_id');
            $table->unsignedInteger('invite_id');

            $table->foreign('invite_id')->references('id')->on('invites');
            $table->foreign('event_id')->references('id')->on('events');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invite_events');
        Schema::dropIfExists('invites');
    }
}
