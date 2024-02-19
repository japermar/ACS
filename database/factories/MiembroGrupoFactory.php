<?php

namespace Database\Factories;

use App\Models\MiembroGrupo;
use App\Models\GruposColaboracion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MiembroGrupoFactory extends Factory
{
    protected $model = MiembroGrupo::class;

    public function definition()
    {
        return [
            'grupo_id' => GruposColaboracion::factory(),
            'user_id' => User::factory(),
            'rol' => $this->faker->randomElement(['admin', 'monitor', 'editar']),
            'created_at' => $this->faker->dateTime,
            'updated_at' => $this->faker->dateTime,
        ];
    }
}
