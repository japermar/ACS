<?php

namespace Database\Factories;

use App\Models\AplicacionDocker;
use App\Models\Servidor;
use Illuminate\Database\Eloquent\Factories\Factory;

class AplicacionDockerFactory extends Factory
{
    protected $model = AplicacionDocker::class;

    public function definition()
    {
        return [
            'servidor_id' => Servidor::factory(),
            'nombre_app' => $this->faker->word,
            'version_app' => $this->faker->word,
            'estado' => $this->faker->randomElement(['corriendo', 'detenido', 'pausado']),
            'created_at' => $this->faker->dateTime,
            'updated_at' => $this->faker->dateTime,
        ];
    }
}
