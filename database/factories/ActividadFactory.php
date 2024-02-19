<?php

namespace Database\Factories;

use App\Models\Actividad;
use App\Models\User;
use App\Models\Servidor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActividadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Actividad::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'servidor_id' => Servidor::factory(),
            'accion' => $this->faker->sentence,
            'created_at' => $this->faker->dateTime,
            'updated_at' => $this->faker->dateTime,
        ];
    }
}
