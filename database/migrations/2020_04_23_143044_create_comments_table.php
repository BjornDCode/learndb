<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->bigInteger('author_id')->unsigned()->nullable();
            $table->bigInteger('lesson_id')->unsigned()->nullable();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('users');
            $table->foreign('lesson_id')->references('id')->on('lessons');
            $table->foreign('parent_id')->references('id')->on('comments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
