<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('tags', function (Blueprint $table) {

            $table->increments('id');

            $table->string('name');
            $table->string('slug')->unique();

            $table->string('description')->nullable();

            $table->timestamps();
        });

        Schema::create('products_tags', function (Blueprint $table) {
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');

            $table->integer('tag_id')->unsigned();
            $table->foreign('tag_id')->references('id')->on('tags');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('tags');
        Schema::dropIfExists('products_tags');
    }
}
