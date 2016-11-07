<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Create Emergency Contacts Table
 *
 * @author  James Drew <jdrew9@hotmail.co.uk>
 * @version 0.1.0
 * @since   0.3.0 Introduced this migration
 */
class CreateEmergencyContactsTable extends Migration
{
    /**
     * Run the migrations
     */
    public function up()
    {
        Schema::create('emergency_contacts', function (Blueprint $table) {
            $table->increments('id');

            $table->string('relationship')->required();
            $table->string('first_name')->required();
            $table->string('last_name')->required();
            $table->string('phone')->required();
            $table->string('email')->required();
            $table->string('address')->required();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations
     */
    public function down()
    {
        Schema::table('emergency_contacts', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('emergency_contacts');
    }
}
