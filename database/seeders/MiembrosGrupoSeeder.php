<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MiembrosGrupoSeeder extends Seeder
{
    public function run()
    {
        \App\Models\MiembroGrupo::factory(10)->create();
    }
}
