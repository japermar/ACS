<?php

namespace Database\Factories;

use App\Models\HardwareServidor;
use App\Models\Servidor;
use Illuminate\Database\Eloquent\Factories\Factory;

class HardwareServidorFactory extends Factory
{
    protected $model = HardwareServidor::class;

    public function definition()
    {
        return [
            'servidor_id' => Servidor::factory(),
            'cpu' => $this->faker->word,
            'ram' => $this->faker->randomDigitNotNull . ' GB',
            'almacenamiento' => $this->faker->randomDigitNotNull . ' GB',
            'velocidad_red' => $this->faker->numberBetween(100, 1000) . ' Mbps',
            'created_at' => $this->faker->dateTime,
            'updated_at' => $this->faker->dateTime,
        ];
    }
}
