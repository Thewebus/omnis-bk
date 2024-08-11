<?php

namespace Database\Factories;

use App\Models\Institut;
use App\Models\Professeur;
use Illuminate\Database\Eloquent\Factories\Factory;

class InstitutProfesseurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'institut_id' => Institut::all()->random()->id,
            'professeur_id' => Professeur::all()->random()->id,
        ];
    }
}
