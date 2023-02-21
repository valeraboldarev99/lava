<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsFilesTable extends Migration
{
    public function up()
    {
        Schema::create('news_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('saved_name')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_size')->nullable();
            $table->string('format')->nullable();
            $table->integer('position');
            $table->bigInteger('parent_id')->unsigned();
            $table->foreign('parent_id')->references('id')->on('news')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('news_files');
    }
}