<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ActividadesSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Actividad::factory(10)->create();
    }
}
