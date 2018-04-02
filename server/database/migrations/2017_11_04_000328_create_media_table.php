<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('thumbnail')->unique();
            $table->string('medium')->unique();
            $table->string('large')->unique();
            $table->string('original')->unique();
            $table->string('alt')->nullable();
            $table->string('description')->nullable();
            $table->integer('gallery_id')->nullable()->unsigned();
            $table->timestamps();

            // Foreign keys
            $table->foreign('gallery_id')->references('id')->on('galleries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medias');
    }
}
