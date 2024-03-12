<?php

namespace Database\Factories;

use App\Models\Servidor;
use App\Models\GruposColaboracion;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServidorFactory extends Factory
{
    protected $model = Servidor::class;

    public function definition()
    {
        return [
            'grupo_id' => GruposColaboracion::factory(),
            'nombre_servidor' => $this->faker->word,
            'direccion_ssh' => $this->faker->ipv4,
            'puerto_ssh' => $this->faker->numberBetween(1024, 65535),
            'usuario_ssh' => $this->faker->userName,
            'contrasena_ssh' => $this->faker->password,
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
        ];
    }
}
