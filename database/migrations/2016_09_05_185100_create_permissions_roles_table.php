<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePermissionsRolesTable extends Migration
{
    /**
     * Run the migrations
     */
    public function up()
    {
        Schema::create('permission_role', function (Blueprint $table) {
            $table->unsignedInteger('permission_id');
            $table->unsignedInteger('role_id');

            $table->foreign('permission_id')->references('id')->on('permissions');
            $table->foreign('role_id')->references('id')->on('roles');
        });

        $this->populate();
    }

    /**
     * Reverse the migrations
     */
    public function down()
    {
        Schema::table('permission_role', function (Blueprint $table) {
            $table->dropForeign(['permission_id']);
            $table->dropForeign(['role_id']);
        });

        Schema::drop('permission_role');
    }

    /**
     * Populate the table with required data
     */
    private function populate()
    {
        $data = require __DIR__ . '/data/permission_roles.php';

        foreach($data as $datum){
            $role_id   = DB::table('roles')->where('name', '=', $datum['role_name'])->first()->id;

            foreach($datum['permission_names'] as $name){
                $permission_id = DB::table('permissions')->where('name', '=', $name)->first()->id;

                DB::table('permission_role')->insert([
                    'permission_id' => $permission_id,
                    'role_id'       => $role_id,
                ]);
            }


        }
    }
}
