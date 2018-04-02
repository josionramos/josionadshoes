<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('title');
            $table->string('sku')->nullable()->unique();
            $table->string('slug')->unique();
            $table->boolean('active')->default(false);
            $table->boolean('featured')->default(false);
            $table->integer('price')->unsigned();
            $table->integer('price_sale')->nullable()->unsigned();
            $table->integer('category_id')->unsigned();
            $table->text('content')->nullable();
            $table->string('description')->nullable();
            $table->integer('media_id')->nullable()->unsigned();
            $table->integer('gallery_id')->nullable()->unsigned();
            $table->integer('weight')->nullable()->unsigned();
            $table->integer('width')->nullable()->unsigned();
            $table->integer('height')->nullable()->unsigned();
            $table->integer('length')->nullable()->unsigned();
            $table->integer('stock')->nullable()->unsigned();
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('media_id')->references('id')->on('medias');
            $table->foreign('gallery_id')->references('id')->on('galleries');
            $table->foreign('category_id')->references('id')->on('product_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
