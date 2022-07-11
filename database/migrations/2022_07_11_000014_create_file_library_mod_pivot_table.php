<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileLibraryModPivotTable extends Migration
{
    public function up()
    {
        Schema::create('file_library_mod', function (Blueprint $table) {
            $table->unsignedBigInteger('mod_id');
            $table->foreign('mod_id', 'mod_id_fk_6052112')->references('id')->on('mods')->onDelete('cascade');
            $table->unsignedBigInteger('file_library_id');
            $table->foreign('file_library_id', 'file_library_id_fk_6052112')->references('id')->on('file_libraries')->onDelete('cascade');
        });
    }
}
