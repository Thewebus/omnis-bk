<?php

namespace Database\Factories;

use App\Models\AnneeAcademique;
use App\Models\Matiere;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class HeureAbsenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'heure_absence' => $this->faker->randomNumber(2, false),
            'user_id' => User::all()->random()->id,
            'matiere_id' => Matiere::all()->random()->id,
            'annee_academique_id' => AnneeAcademique::all()->random()->id,
        ];
    }
}
