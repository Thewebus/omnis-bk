<?php

namespace Database\Factories;

use App\Models\AnneeAcademique;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Professeur;
use Illuminate\Database\Eloquent\Factories\Factory;

class CahierTexteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => now(),
            'duree' => $this->faker->numberBetween(2, 4),
            'contenu' => $this->faker->sentence(),
            'bibliographie' => $this->faker->sentence(),
            'classe_id' => Classe::all()->random()->id,
            'matiere_id' => Matiere::all()->random()->id,
            'professeur_id' => Professeur::all()->random()->id,
            'annee_academique_id' => AnneeAcademique::all()->random()->id,
        ];
    }
}
