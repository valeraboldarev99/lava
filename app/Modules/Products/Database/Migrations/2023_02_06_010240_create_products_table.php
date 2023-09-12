<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('lang', ['ru', 'en']);
            $table->integer('position')->nullable()->default(0);
            $table->bigInteger('category_id')->unsigned();
            $table->string('title')->nullable()->index();
            $table->string('image')->nullable();
            $table->string('bg')->nullable();
            $table->string('file')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_size')->nullable();
            $table->string('file2')->nullable();
            $table->string('file_name2')->nullable();
            $table->string('file_size2')->nullable();
            $table->tinyInteger('active')->default(0);
            $table->foreign('category_id')->references('id')->on('products_categories')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}