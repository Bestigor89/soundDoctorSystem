<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToFileForeModsTable extends Migration
{
    public function up()
    {
        Schema::table('file_fore_mods', function (Blueprint $table) {
            $table->unsignedBigInteger('file_id')->nullable();
            $table->foreign('file_id', 'file_fk_7069472')->references('id')->on('file_libraries');
            $table->unsignedBigInteger('mod_id')->nullable();
            $table->foreign('mod_id', 'mod_fk_7069474')->references('id')->on('mods');
        });
    }
}
