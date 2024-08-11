<?php

namespace Database\Factories;

use App\Models\Faculte;
use Illuminate\Database\Eloquent\Factories\Factory;

class NiveauFaculteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nom' => $this->faker->randomElement(['bts 1', 'bts 2', 'licence 1', 'licence 2', 'licence 3', 'master 1', 'master 2',]),
            'scolarite_affecte' => $this->faker->randomElement(['1500000', '2000000', '2500000']),
            'scolarite_nonaffecte' => $this->faker->randomElement(['1500000', '2000000', '2500000']),
            'scolarite_reaffecte' => $this->faker->randomElement(['1500000', '2000000', '2500000']),
            'faculte_id' => Faculte::all()->random()->id,
        ];
    }
}
