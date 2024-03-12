<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class HardwareServidorSeeder extends Seeder
{
    public function run()
    {
        \App\Models\HardwareServidor::factory(10)->create();
    }
}
