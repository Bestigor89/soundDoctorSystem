<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileLibrarySectionPivotTable extends Migration
{
    public function up()
    {
        Schema::create('file_library_section', function (Blueprint $table) {
            $table->unsignedBigInteger('file_library_id');
            $table->foreign('file_library_id', 'file_library_id_fk_6965756')->references('id')->on('file_libraries')->onDelete('cascade');
            $table->unsignedBigInteger('section_id');
            $table->foreign('section_id', 'section_id_fk_6965756')->references('id')->on('sections')->onDelete('cascade');
        });
    }
}
