<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('cover', 128);
            $table->text('description');
            $table->string('language', 15);
            $table->enum('status', ['DRAFT', 'PUBLISH', 'UNPUBLISH']);
            $table->integer('price')->nullable()->default(0);
            $table->bigInteger('user_id')->unsigned();
            $table->uuid('genre_id');
            $table->uuid('licence_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('cascade');
            $table->foreign('licence_id')->references('id')->on('licences')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stories');
    }
}
