<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');
            $table->string('slug');
            $table->string('excerpt', 250);
            $table->string('picture_url')->nullable();
            $table->longText('body');

            $table->unsignedInteger('author_id');
            $table->boolean('comments_enabled')->default(true);

            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign(['author_id']);
        });

        Schema::drop('articles');
    }
}
