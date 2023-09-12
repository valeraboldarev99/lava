<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsFiles1Table extends Migration
{
    public function up()
    {
        Schema::create('products_files1', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('saved_name')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_size')->nullable();
            $table->string('format')->nullable();
            $table->integer('position')->nullable()->default(0);
            $table->bigInteger('parent_id')->unsigned();
            $table->foreign('parent_id')->references('id')->on('products')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products_files1');
    }
}