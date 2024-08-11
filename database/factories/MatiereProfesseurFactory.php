<?php

namespace Database\Factories;

use App\Models\AnneeAcademique;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Professeur;
use Illuminate\Database\Eloquent\Factories\Factory;

class MatiereProfesseurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'volume_horaire' => $this->faker->numberBetween(40, 60),
            'progression' => $this->faker->numberBetween(30, 40),
            'statut' => 'en cours',
            'matiere_id' => Matiere::all()->random()->id,
            'professeur_id' => Professeur::all()->random()->id,
            'classe_id' => Classe::all()->random()->id,
            'annee_academique_id' => AnneeAcademique::all()->random()->id,
        ];
    }
}
