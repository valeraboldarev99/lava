<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('lang', ['ru', 'en'])->index();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->tinyInteger('active')->default(1);
            $table->enum('type', ['html', 'wysiwyg'])->default('html');
            $table->text('content')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
