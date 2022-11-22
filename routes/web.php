<?php

use App\Http\Controllers\Admin\CostController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\FileForeModController;
use App\Http\Controllers\Admin\FileLibraryController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ManagerController;
use App\Http\Controllers\Admin\ModController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\TaskForPatientController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\UserProfileController;
use App\Http\Controllers\PatientProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'has_role:Admin,Doctor']], routes: function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Permissions
    Route::resource('permissions', PermissionController::class, ['except' => ['store', 'update', 'destroy']]);

    // Roles
    Route::resource('roles', RoleController::class, ['except' => ['store', 'update', 'destroy']]);

    // Users
    Route::resource('users', UserController::class, ['except' => ['store', 'update', 'destroy']]);

    // Sections
    Route::resource('sections', SectionController::class, ['except' => ['store', 'update', 'destroy']]);

    // Mods
    Route::resource('mods', ModController::class, ['except' => ['store', 'update', 'destroy']]);

    // File Library
    Route::post('file-libraries/media', [FileLibraryController::class, 'storeMedia'])->name('file-libraries.storeMedia');
    Route::resource('file-libraries', FileLibraryController::class, ['except' => ['store', 'update', 'destroy']]);

    // Cost
    Route::resource('costs', CostController::class, ['except' => ['store', 'update', 'destroy']]);

    // Doctor
    Route::resource('doctors', DoctorController::class, ['except' => ['store', 'update', 'destroy']]);

    // Patient
    Route::resource('patients', PatientController::class, ['except' => ['store', 'update', 'destroy']]);

    // Task For Patient
    Route::resource('task-for-patients', TaskForPatientController::class, ['except' => ['store', 'update', 'destroy']]);

    // File Fore Mod
    Route::resource('file-fore-mods', FileForeModController::class, ['except' => ['store', 'update', 'destroy']]);

    Route::get('manager/{task_for_patient}/copy', [ManagerController::class, 'copy'])->name('manager.copy');
    Route::resource('manager', ManagerController::class, ['except' => ['store', 'update', 'destroy']]);

    // Reports
    Route::get('reports/patients', [\App\Http\Controllers\Admin\Reports\PatientController::class, 'index'])
        ->name('reports.patients');
});

Route::group(['middleware' => ['auth', 'has_role:Patient']], function () {
    Route::get('patient', [PatientProfileController::class, 'index'])
        ->name('patient.profile');

    Route::get('patient/tasks', [PatientProfileController::class, 'tasks'])
        ->name('patient.tasks');
});

Route::group(['prefix' => 'profile', 'as' => 'profile.', 'middleware' => ['auth']], function () {
    if (file_exists(app_path('Http/Controllers/Auth/UserProfileController.php'))) {
        Route::get('/', [UserProfileController::class, 'show'])->name('show');
    }
});
