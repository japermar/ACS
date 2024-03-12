<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GruposColaboracionSeeder extends Seeder
{
    public function run()
    {
        \App\Models\GruposColaboracion::factory()->count(10)->create();
    }
}
