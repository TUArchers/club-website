<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * CreateDemographicsTable
 *
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class CreateDemographicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demographics', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('user_id')->required();

            $table->enum('school', ['SCM', 'DCA', 'SOH', 'SSE', 'SSSBL', 'STAFF', 'ASSOC', 'O'])->nullable();
            $table->enum('subject', ['Sc', 'A', 'Ed', 'Eng', 'Ph', 'BA', 'O' , 'NA'])->nullable();
            $table->enum('qualification', ['Dip', 'Fd', 'B', 'M', 'D', 'O', 'NA'])->nullable();
            $table->enum('year', ['1', '2', '3', '4', '5', '6', '7', 'NA'])->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('demographics');
    }
}
