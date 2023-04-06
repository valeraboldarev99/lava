<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('lang', ['ru', 'en'])->index();
            $table->datetime('datetime')->useCurrent();
            $table->bigInteger('ip');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->text('message');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}