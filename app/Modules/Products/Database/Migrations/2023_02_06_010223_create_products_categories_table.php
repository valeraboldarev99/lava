<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('products_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('lang', ['ru', 'en'])->index();
            $table->string('title')->nullable();
            $table->tinyInteger('active')->default(1);
            $table->string('category_image')->nullable();
            $table->string('category_bg')->nullable();
            $table->string('category_file')->nullable();
            $table->string('category_file_name')->nullable();
            $table->string('category_file_size')->nullable();
            $table->string('category_file2')->nullable();
            $table->string('category_file_name2')->nullable();
            $table->string('category_file_size2')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products_categories');
    }
}