<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackuperTable extends Migration
{
    public function up()
    {
        Schema::create('backuper', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('dump_type', ['files', 'data_base'])->index();
            $table->string('user_login')->nullable();
            $table->ipAddress('ip');
            $table->dateTime('datetime')->useCurrent();
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->tinyInteger('all_time')->default(0);
            $table->string('folder')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('backuper');
    }
}