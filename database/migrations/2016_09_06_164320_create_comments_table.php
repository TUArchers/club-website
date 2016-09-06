<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('author_id');
            $table->unsignedInteger('article_id');
            $table->unsignedInteger('parent_id')->nullable();

            $table->text('body');

            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('users');
            $table->foreign('article_id')->references('id')->on('articles');
            $table->foreign('parent_id')->references('id')->on('comments');
        });
    }

    /**
     * Reverse the migrations
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['author_id']);
            $table->dropForeign(['article_id']);
            $table->dropForeign(['parent_id']);
        });

        Schema::drop('comments');
    }
}
