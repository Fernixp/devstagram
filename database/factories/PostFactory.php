<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        //libreria faker para realizar pruebas
        return [
            'titulo' => $this->faker->sentence(5), //asignar cuantas palabras
            'descripcion' => $this->faker->sentence(20),
            'imagen' => $this->faker->uuid().'.jpg', // uuid unique id 
            'user_id' => $this->faker->randomElement([1,2,3]), //genera numeros aleatorios, cualquiera de los que estan en el array 1,2,3
        ];
    }
}
