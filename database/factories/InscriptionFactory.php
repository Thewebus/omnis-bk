c<?php

namespace Database\Factories;

use App\Models\AnneeAcademique;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'frais_inscription' => $this->faker->numberBetween(70000, 100000),
            'nom_banque' => $this->faker->word(),
            'numero_bordereau' => $this->faker->word(),
            'numero_recu' => $this->faker->unique()->word(),
            'date_inscription' => now(),
            'date_versement' => now(),
            'net_payer' => $this->faker->randomElement([1500000, 2000000, 2500000]),
            'valide' => $this->faker->randomElement([0, 1]),
            'raison' => $this->faker->randomElement([0, 1]),
            'user_id' => User::all()->random()->id,
            'annee_academique_id' => AnneeAcademique::all()->random()->id,
        ];
    }
}
