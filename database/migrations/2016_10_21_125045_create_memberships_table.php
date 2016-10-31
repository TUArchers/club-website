<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use TuaWebsite\Domain\Identity\Organisation;

/**
 * Create Memberships Table
 *
 * @author  James Drew <jdrew9@hotmail.co.uk>
 * @version 0.1.0
 * @since   0.1.0 Introduced this class
 */
class CreateMembershipsTable extends Migration
{
    /**
     * Run the migrations
     */
    public function up()
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('user_id')->required();
            $table->enum('organisation', Organisation::keys())->required();
            $table->string('number')->nullable();
            $table->string('description')->nullable();

            $table->dateTime('valid_from')->nullable();
            $table->dateTime('expires_at')->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations
     */
    public function down()
    {
        Schema::table('memberships', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('memberships');
    }
}
