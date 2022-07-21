<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStructureTable extends Migration
{
    public function up()
    {
        Schema::create('structure', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('parent_id')->nullable()->index();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->tinyInteger('active')->default(1);
            $table->text('content')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('structure');
    }
}
