<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sku')->nullable()->unique();
            $table->integer('price')->unsigned();
            $table->string('value');
            $table->string('extra')->nullable();
            $table->boolean('active')->default(false);
            $table->integer('media_id')->nullable()->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('type_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('media_id')->references('id')->on('medias');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('type_id')->references('id')->on('product_variant_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variants');
    }
}
