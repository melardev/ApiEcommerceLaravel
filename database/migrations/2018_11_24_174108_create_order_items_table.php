<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('order_id')->unsigned()->nullable(false);
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            $table->integer('product_id')->unsigned()->nullable(false);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->string('name');
            $table->string('slug');

            $table->integer('quantity')->unsigned();
            $table->decimal('price')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
