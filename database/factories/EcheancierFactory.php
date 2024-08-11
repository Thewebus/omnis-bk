<?php

namespace Database\Factories;

use App\Models\AnneeAcademique;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EcheancierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'versement_1' => $this->faker->numberBetween(320000, 360000),
            'date_1' => '22/12/2022',
            'versement_2' => $this->faker->numberBetween(320000, 360000),
            'date_2' => '22/12/2022',
            'versement_3' => $this->faker->numberBetween(320000, 360000),
            'date_3' => '22/12/2022',
            'versement_4' => $this->faker->numberBetween(320000, 360000),
            'date_4' => '22/12/2022',
            'versement_5' => $this->faker->numberBetween(320000, 360000),
            'date_5' => '22/12/2022',
            'versement_6' => $this->faker->numberBetween(320000, 360000),
            'date_6' => '22/12/2022',
            'versement_7' => $this->faker->numberBetween(320000, 360000),
            'date_7' => '22/12/2022',
            'user_id' => User::all()->random()->id,
            'annee_academique_id' => AnneeAcademique::all()->random()->id,
        ];
    }
}
