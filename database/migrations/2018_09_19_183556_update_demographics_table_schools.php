<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * UpdateDemographicsTableSchools
 *
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class UpdateDemographicsTableSchools extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('demographics', function(Blueprint $table){
            $table->enum('school', ['SCM', 'SOH', 'SSE', 'SSSHL', 'TUBS', 'STAFF', 'ASSOC', 'O'])->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('demographics', function(Blueprint $table){
            $table->enum('school', ['SCM', 'DCA', 'SOH', 'SSE', 'SSSBL', 'STAFF', 'ASSOC', 'O'])->nullable()->change();
        });
    }
}
