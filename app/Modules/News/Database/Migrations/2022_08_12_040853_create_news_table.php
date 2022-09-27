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
            $table->enum('lang', ['ru', 'en'])->index();
            $table->string('title')->nullable();
            $table->string('date')->nullable();
            $table->string('image')->nullable();
            $table->string('bg')->nullable();
            $table->string('file')->nullable();
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