<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('price')->unsigned();
            $table->integer('tax')->unsigned()->nullable();
            $table->string('reference', 50)->unique();
            $table->integer('order_id')->unsigned();
            $table->integer('type_id')->unsigned();
            $table->integer('gateway_id')->unsigned();
            $table->timestamps();

            // Foreign keys
            $table->foreign('type_id')->references('id')->on('payment_types');
            $table->foreign('gateway_id')->references('id')->on('payment_gateways');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
