<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
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

            Role::factory()->create($item);

            $this->command->line(__(' - The role with title :title created', $item));
        }
    }

    /**
     * @param array $item
     * @return bool
     */
    protected function exists(array $item)
    {
        return Role::query()->where('title', data_get($item, 'title'))->exists();
    }

    /**
     * @return array
     */
    protected function getItems()
    {
        return [
            [
                'title' => 'Admin',
            ],
            [
                'title' => 'Patient',
            ],
            [
                'title' => 'Doctor',
            ],
        ];
    }
}
