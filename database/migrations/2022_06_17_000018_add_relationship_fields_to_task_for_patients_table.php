<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTaskForPatientsTable extends Migration
{
    public function up()
    {
        Schema::table('task_for_patients', function (Blueprint $table) {
            $table->unsignedBigInteger('pacient_id')->nullable();
            $table->foreign('pacient_id', 'pacient_fk_6052214')->references('id')->on('patients');
            $table->unsignedBigInteger('cost_id')->nullable();
            $table->foreign('cost_id', 'cost_fk_6052215')->references('id')->on('costs');
            $table->unsignedBigInteger('mode_id')->nullable();
            $table->foreign('mode_id', 'mode_fk_6052216')->references('id')->on('mods');
        });
    }
}
