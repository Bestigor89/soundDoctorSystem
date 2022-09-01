<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        foreach ($this->getItems() as $item) {
            if ($this->itemExist($item)) {
                continue;
            }

            User::factory()->create($item);

            $this->command->line(__(' - The user with email :email created', $item));
        }
    }

    /**
     * @param array $item
     * @return bool
     */
    protected function itemExist(array $item)
    {
        return User::query()->where('email', data_get($item, 'email'))->exists();
    }

    /**
     * @return array
     */
    protected function getItems()
    {
        return [
            [
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'locale'         => '',
            ],
            [
                'name'           => 'Default',
                'email'          => 'default@site.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'locale'         => '',
            ],
            [
                'name'           => 'Patient',
                'email'          => 'patient@site.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'locale'         => '',
            ],
        ];
    }
}
