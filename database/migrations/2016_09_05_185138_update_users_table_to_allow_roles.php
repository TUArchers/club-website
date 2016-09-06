<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateUsersTableToAllowRoles extends Migration
{
    /**
     * Run the migrations
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('role_id')->after('id');
        });

        $this->populate();

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });
    }

    /**
     * Populate the table with required data
     */
    private function populate()
    {
        $data = require __DIR__ . '/data/user_roles.php';

        foreach($data as $datum){
            $role_id = DB::table('roles')->where('name', '=', $datum['role_name'])->first()->id;

            DB::table('users')
                ->where('id', $datum['id'])
                ->update(['role_id' => $role_id]);
        }
    }
}
