<?php

use App\Enums\TaskForPatientStatusEnum;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('fix:task-for-patients', function () {
    Schema::table('task_for_patients', function (\Illuminate\Database\Schema\Blueprint $table) {
        $table->dropColumn('status');
    });

    Schema::table('task_for_patients', function (\Illuminate\Database\Schema\Blueprint $table) {
        $table->enum('status', TaskForPatientStatusEnum::list())->default(TaskForPatientStatusEnum::HIDDEN);
    });
});
