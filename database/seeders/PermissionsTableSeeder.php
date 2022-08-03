<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'auth_profile_edit',
            ],
            [
                'id'    => 2,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 3,
                'title' => 'permission_create',
            ],
            [
                'id'    => 4,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 5,
                'title' => 'permission_show',
            ],
            [
                'id'    => 6,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 7,
                'title' => 'permission_access',
            ],
            [
                'id'    => 8,
                'title' => 'role_create',
            ],
            [
                'id'    => 9,
                'title' => 'role_edit',
            ],
            [
                'id'    => 10,
                'title' => 'role_show',
            ],
            [
                'id'    => 11,
                'title' => 'role_delete',
            ],
            [
                'id'    => 12,
                'title' => 'role_access',
            ],
            [
                'id'    => 13,
                'title' => 'user_create',
            ],
            [
                'id'    => 14,
                'title' => 'user_edit',
            ],
            [
                'id'    => 15,
                'title' => 'user_show',
            ],
            [
                'id'    => 16,
                'title' => 'user_delete',
            ],
            [
                'id'    => 17,
                'title' => 'user_access',
            ],
            [
                'id'    => 18,
                'title' => 'section_create',
            ],
            [
                'id'    => 19,
                'title' => 'section_edit',
            ],
            [
                'id'    => 20,
                'title' => 'section_show',
            ],
            [
                'id'    => 21,
                'title' => 'section_delete',
            ],
            [
                'id'    => 22,
                'title' => 'section_access',
            ],
            [
                'id'    => 23,
                'title' => 'mod_create',
            ],
            [
                'id'    => 24,
                'title' => 'mod_edit',
            ],
            [
                'id'    => 25,
                'title' => 'mod_show',
            ],
            [
                'id'    => 26,
                'title' => 'mod_delete',
            ],
            [
                'id'    => 27,
                'title' => 'mod_access',
            ],
            [
                'id'    => 28,
                'title' => 'file_library_create',
            ],
            [
                'id'    => 29,
                'title' => 'file_library_edit',
            ],
            [
                'id'    => 30,
                'title' => 'file_library_show',
            ],
            [
                'id'    => 31,
                'title' => 'file_library_delete',
            ],
            [
                'id'    => 32,
                'title' => 'file_library_access',
            ],
            [
                'id'    => 33,
                'title' => 'cost_create',
            ],
            [
                'id'    => 34,
                'title' => 'cost_edit',
            ],
            [
                'id'    => 35,
                'title' => 'cost_show',
            ],
            [
                'id'    => 36,
                'title' => 'cost_delete',
            ],
            [
                'id'    => 37,
                'title' => 'cost_access',
            ],
            [
                'id'    => 38,
                'title' => 'doctor_create',
            ],
            [
                'id'    => 39,
                'title' => 'doctor_edit',
            ],
            [
                'id'    => 40,
                'title' => 'doctor_show',
            ],
            [
                'id'    => 41,
                'title' => 'doctor_delete',
            ],
            [
                'id'    => 42,
                'title' => 'doctor_access',
            ],
            [
                'id'    => 43,
                'title' => 'patient_create',
            ],
            [
                'id'    => 44,
                'title' => 'patient_edit',
            ],
            [
                'id'    => 45,
                'title' => 'patient_show',
            ],
            [
                'id'    => 46,
                'title' => 'patient_delete',
            ],
            [
                'id'    => 47,
                'title' => 'patient_access',
            ],
            [
                'id'    => 48,
                'title' => 'task_for_patient_create',
            ],
            [
                'id'    => 49,
                'title' => 'task_for_patient_edit',
            ],
            [
                'id'    => 50,
                'title' => 'task_for_patient_show',
            ],
            [
                'id'    => 51,
                'title' => 'task_for_patient_delete',
            ],
            [
                'id'    => 52,
                'title' => 'task_for_patient_access',
            ],
            [
                'id'    => 53,
                'title' => 'file_fore_mod_create',
            ],
            [
                'id'    => 54,
                'title' => 'file_fore_mod_edit',
            ],
            [
                'id'    => 55,
                'title' => 'file_fore_mod_show',
            ],
            [
                'id'    => 56,
                'title' => 'file_fore_mod_delete',
            ],
            [
                'id'    => 57,
                'title' => 'file_fore_mod_access',
            ],
        ];

        Permission::insert($permissions);
    }
}
