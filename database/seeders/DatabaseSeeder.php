<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            GruposColaboracionSeeder::class,
            ServidoresSeeder::class,
            AplicacionesDockerSeeder::class,
            HardwareServidorSeeder::class,
            ActividadesSeeder::class,
            MiembrosGrupoSeeder::class,
        ]);
    }
}
