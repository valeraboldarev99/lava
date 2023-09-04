<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchTable extends Migration
{
    public function up()
    {
        Schema::create('search', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('date')->useCurrent();
            $table->ipAddress('ip');
            $table->string('query');
            $table->integer('results');
        });
    }

    public function down()
    {
        Schema::dropIfExists('search');
    }
}