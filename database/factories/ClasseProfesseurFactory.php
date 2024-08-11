<?php

namespace Database\Factories;

use App\Models\AnneeAcademique;
use App\Models\Classe;
use App\Models\Professeur;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClasseProfesseurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'classe_id' => Classe::all()->random()->id,
            'professeur_id' => Professeur::all()->random()->id,
            'annee_academique_id' => AnneeAcademique::all()->random()->id,
        ];
    }
}
