<?php

use App\Enums\TaskForPatientStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskForPatientsTable extends Migration
{
    public function up()
    {
        Schema::create('task_for_patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('status', TaskForPatientStatusEnum::list())->default(TaskForPatientStatusEnum::HIDDEN);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
