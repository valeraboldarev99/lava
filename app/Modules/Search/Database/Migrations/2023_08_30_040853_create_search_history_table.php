<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchHistoryTable extends Migration
{
    public function up()
    {
        Schema::create('search_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('lang', ['ru', 'en'])->index();
            $table->dateTime('date')->useCurrent();
            $table->ipAddress('ip');
            $table->string('query');
            $table->integer('results');
        });
    }

    public function down()
    {
        Schema::dropIfExists('search_history');
    }
}