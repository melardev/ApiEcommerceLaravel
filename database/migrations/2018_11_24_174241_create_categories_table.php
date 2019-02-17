<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('slug');
            $table->string('description')->nullable();
            $table->unique('slug');

            Schema::create('products_categories', function (Blueprint $table) {
                $table->integer('product_id')->unsigned();
                $table->foreign('product_id')->references('id')->on('products');

                $table->integer('category_id')->unsigned();
                $table->foreign('category_id')->references('id')->on('categories');

                $table->timestamps();
            });
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
        Schema::dropIfExists('categories');
        Schema::dropIfExists('products_categories');
    }
}
