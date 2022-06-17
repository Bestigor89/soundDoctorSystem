<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileLibrariesTable extends Migration
{
    public function up()
    {
        Schema::create('file_libraries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('durations');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
