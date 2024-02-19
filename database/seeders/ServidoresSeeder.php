<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class ServidoresSeeder extends Seeder
{
    use HasFactory;
    protected $table = 'servidores';
    public function run()
    {
        \App\Models\Servidor::factory(10)->create();
    }
}
