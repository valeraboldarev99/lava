<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('lang', ['ru', 'en']);
            $table->integer('position')->nullable()->default(0);
            $table->string('title')->nullable()->index();
            $table->string('date')->nullable();
            $table->string('image')->nullable();
            $table->string('bg')->nullable();
            $table->string('file')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_size')->nullable();
            $table->string('multi_images')->nullable();
            $table->string('preview')->nullable();
            $table->tinyInteger('active')->default(1);
            $table->text('content')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('news');
    }
}