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
            $table->enum('lang', ['ru', 'en'])->index();
            $table->integer('depth')->nullable();
            $table->integer('position')->nullable()->default(1);
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('module')->nullable();
            $table->tinyInteger('redirector')->default(0)->nullable();
            $table->string('redirect_url')->nullable();
            $table->string('template')->nullable();
            $table->tinyInteger('active')->default(1);
            $table->tinyInteger('in_main_menu')->nullable()->default(0);
            $table->tinyInteger('in_bottom_menu')->nullable()->default(0);
            $table->text('content')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('structure');
    }
}
