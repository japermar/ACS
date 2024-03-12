<?php
namespace Database\Factories;

use App\Models\GruposColaboracion;
use Illuminate\Database\Eloquent\Factories\Factory;

class GruposColaboracionFactory extends Factory
{
    protected $model = GruposColaboracion::class;

    public function definition()
    {
        return [
            'nombre_grupo' => $this->faker->word,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
