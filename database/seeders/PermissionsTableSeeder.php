<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        foreach ($this->getItems() as $item) {
            if ($this->exists($item)) {
                continue;
            }

            Permission::factory()->create($item);

            $this->command->line(__(' - The permission with title :title created', $item));
        }
    }

    /**
     * @param $item
     * @return bool
     */
    protected function exists($item)
    {
        return Permission::query()->where('title', data_get($item, 'title'))->exists();
    }

    /**
     * @return array
     */
    protected function getItems()
    {
        return [
            [
                'title' => 'auth_profile_edit',
            ],
            [
                'title' => 'user_management_access',
            ],
            [
                'title' => 'permission_create',
            ],
            [
                'title' => 'permission_edit',
            ],
            [
                'title' => 'permission_show',
            ],
            [
                'title' => 'permission_delete',
            ],
            [
                'title' => 'permission_access',
            ],
            [
                'title' => 'role_create',
            ],
            [
                'title' => 'role_edit',
            ],
            [
                'title' => 'role_show',
            ],
            [
                'title' => 'role_delete',
            ],
            [
                'title' => 'role_access',
            ],
            [
                'title' => 'user_create',
            ],
            [
                'title' => 'user_edit',
            ],
            [
                'title' => 'user_show',
            ],
            [
                'title' => 'user_delete',
            ],
            [
                'title' => 'user_access',
            ],
            [
                'title' => 'section_create',
            ],
            [
                'title' => 'section_edit',
            ],
            [
                'title' => 'section_show',
            ],
            [
                'title' => 'section_delete',
            ],
            [
                'title' => 'section_access',
            ],
            [
                'title' => 'mod_create',
            ],
            [
                'title' => 'mod_edit',
            ],
            [
                'title' => 'mod_show',
            ],
            [
                'title' => 'mod_delete',
            ],
            [
                'title' => 'mod_access',
            ],
            [
                'title' => 'file_library_create',
            ],
            [
                'title' => 'file_library_edit',
            ],
            [
                'title' => 'file_library_show',
            ],
            [
                'title' => 'file_library_delete',
            ],
            [
                'title' => 'file_library_access',
            ],
            [
                'title' => 'cost_create',
            ],
            [
                'title' => 'cost_edit',
            ],
            [
                'title' => 'cost_show',
            ],
            [
                'title' => 'cost_delete',
            ],
            [
                'title' => 'cost_access',
            ],
            [
                'title' => 'doctor_create',
            ],
            [
                'title' => 'doctor_edit',
            ],
            [
                'title' => 'doctor_show',
            ],
            [
                'title' => 'doctor_delete',
            ],
            [
                'title' => 'doctor_access',
            ],
            [
                'title' => 'patient_create',
            ],
            [
                'title' => 'patient_edit',
            ],
            [
                'title' => 'patient_show',
            ],
            [
                'title' => 'patient_delete',
            ],
            [
                'title' => 'patient_access',
            ],
            [
                'title' => 'task_for_patient_create',
            ],
            [
                'title' => 'task_for_patient_edit',
            ],
            [
                'title' => 'task_for_patient_show',
            ],
            [
                'title' => 'task_for_patient_delete',
            ],
            [
                'title' => 'task_for_patient_access',
            ],
            [
                'title' => 'file_fore_mod_create',
            ],
            [
                'title' => 'file_fore_mod_edit',
            ],
            [
                'title' => 'file_fore_mod_show',
            ],
            [
                'title' => 'file_fore_mod_delete',
            ],
            [
                'title' => 'file_fore_mod_access',
            ],
            [
                'title' => 'patient',
            ],
            [
                'title' => 'patients',
            ],
            [
                'title' => 'reports',
            ],
        ];
    }
}
