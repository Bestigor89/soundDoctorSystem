<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder as BaseSeeder;
use Illuminate\Support\Str;

class Seeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $method = __("run:environment", [
            'environment' => ucfirst(Str::studly(app()->environment()))
        ]);

        if (method_exists($this, $method)) {
            $this->container->call([$this, $method]);
        }
    }
}
