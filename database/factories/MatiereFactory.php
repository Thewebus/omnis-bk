<?php

namespace Database\Factories;

use App\Models\Classe;
use App\Models\UniteEnseignement;
use Illuminate\Database\Eloquent\Factories\Factory;

class MatiereFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nom' => $this->faker->unique()->name(),
            'description' => $this->faker->sentence(),
            'volume_horaire' => $this->faker->numberBetween(40, 60),
            'numero_ordre' => $this->faker->numberBetween(1, 40),
            'coefficient' => $this->faker->randomElement([2, 3, 4, 5]),
            'credit' => $this->faker->randomElement([2, 3, 4, 5]),
            'semestre' => $this->faker->randomElement(['1', '2']),
            'classe_id' => Classe::all()->random()->id,
            'unite_enseignement_id' => UniteEnseignement::all()->random()->id,
        ];
    }
}
