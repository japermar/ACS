<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AplicacionesDockerSeeder extends Seeder
{
    public function run()
    {
        \App\Models\AplicacionDocker::factory(10)->create();
    }
}
