<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        foreach ($this->getItems() as $roleTitle => $permissions) {
            foreach ($permissions as $permission) {
                $role = $this->getRole($roleTitle);

                if (blank($this->getPermission($permission))) {
                    continue;
                }

                $role->permissions()->syncWithoutDetaching($this->getPermission($permission)->id);

                $this->command->line(__(' - The permission with title :title attached to the role :role', [
                    'title' => $permission,
                    'role' => $role->title,
                ]));
            }
        }
    }

    /**
     * @param string $role
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    protected function getRole(string $role)
    {
        return Role::byTitle($role);
    }

    /**
     * @param string $permission
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    protected function getPermission(string $permission)
    {
        return Permission::byTitle($permission);
    }

    /**
     * @return array
     */
    protected function getItems()
    {
        return [
            Role::TITLE_ADMIN => [
                'auth_profile_edit',
                'user_management_access',
                'permission_create',
                'permission_edit',
                'permission_show',
                'permission_delete',
                'permission_access',
                'role_create',
                'role_edit',
                'role_show',
                'role_delete',
                'role_access',
                'user_create',
                'user_edit',
                'user_show',
                'user_delete',
                'user_access',
                'section_create',
                'section_edit',
                'section_show',
                'section_delete',
                'section_access',
                'mod_create',
                'mod_edit',
                'mod_show',
                'mod_delete',
                'mod_access',
                'file_library_create',
                'file_library_edit',
                'file_library_show',
                'file_library_delete',
                'file_library_access',
                'cost_create',
                'cost_edit',
                'cost_show',
                'cost_delete',
                'cost_access',
                'doctor_create',
                'doctor_edit',
                'doctor_show',
                'doctor_delete',
                'doctor_access',
                'patient_create',
                'patient_edit',
                'patient_show',
                'patient_delete',
                'patient_access',
                'task_for_patient_create',
                'task_for_patient_edit',
                'task_for_patient_show',
                'task_for_patient_delete',
                'task_for_patient_access',
                'file_fore_mod_create',
                'file_fore_mod_edit',
                'file_fore_mod_show',
                'file_fore_mod_delete',
                'file_fore_mod_access',
            ],
            Role::TITLE_DOCTOR => [
                'mod_create',
                'mod_edit',
                'mod_show',
                'mod_delete',
                'mod_access',
                'patient_create',
                'patient_edit',
                'patient_show',
                'patient_delete',
                'patient_access',
                'task_for_patient_create',
                'task_for_patient_edit',
                'task_for_patient_show',
                'task_for_patient_delete',
                'task_for_patient_access',
            ],
            Role::TITLE_PATIENT => [
                'patient',
            ],
        ];
    }
}
