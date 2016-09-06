<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');

            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->enum('gender', ['U', 'M', 'F', 'O']);
            $table->dateTime('date_of_birth')->nullable();
            $table->string('picture_url')->nullable();

            $table->string('tusc_id', 8)->nullable()->unique();
            $table->boolean('isStudent');
            $table->string('agb_id')->nullable()->unique();
            $table->string('email_address')->unique();
            $table->boolean('email_address_verified');

            $table->string('password_hash');
            $table->rememberToken();
            $table->dateTime('registered_at');
            $table->timestamps();
        });

        $this->populate();
    }

    /**
     * Reverse the migrations
     */
    public function down()
    {
        Schema::drop('users');
    }

    /**
     * Populate the table with required data
     */
    private function populate()
    {
        $data = require __DIR__ . '/data/users.php';

        foreach($data as $datum){

            $datum['password_hash'] = Hash::make($datum['password']);
            $datum['created_at']    = Carbon::now()->toDateTimeString();

            unset($datum['password']);

            DB::table('users')->insert($datum);
        }
    }
}
