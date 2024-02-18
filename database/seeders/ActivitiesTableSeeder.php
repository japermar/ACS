<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivitiesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('activities')->insert([
            ['user_id' => 1, 'server_id' => 1, 'action' => 'Instalación Docker', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

