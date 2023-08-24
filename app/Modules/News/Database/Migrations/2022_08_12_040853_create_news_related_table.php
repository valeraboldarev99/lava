<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsRelatedTable extends Migration
{
    public function up()
    {
        Schema::create('news_related', function (Blueprint $table) {
            $table->bigInteger('news_id')->unsigned();
            $table->bigInteger('related_id')->unsigned();

            $table->primary(['news_id','related_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('news_related');
    }
}