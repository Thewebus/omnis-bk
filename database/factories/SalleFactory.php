<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SalleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nom' => $this->faker->numerify('N-##'),
            'capacite' => $this->faker->numberBetween(15, 30),
            'batiment' => $this->faker->numerify('B-##'),
        ];
    }
}
