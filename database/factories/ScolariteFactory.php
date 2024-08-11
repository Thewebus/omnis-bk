<?php

namespace Database\Factories;

use App\Models\AnneeAcademique;
use App\Models\User;
use App\Models\Scolarite;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScolariteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Scolarite::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $int= mt_rand(1262055681,1262055681);
        $string = date("Y-m-d H:i:s",$int);
        return [
            'nom_banque' => $this->faker->word(),
            'numero_bordereau' => $this->faker->numerify('NOBOR-#########'),
            'code_caisse' => $this->faker->numerify('#########'),
            'numero_recu' => $this->faker->unique()->numerify('RE-#########'),
            'date_versement' => $string,
            'montant_scolarite' => $this->faker->randomElement([1500000, 2000000, 2500000]),
            'net_payer' => $this->faker->randomElement([1500000, 2000000, 2500000]),
            'payee' => $this->faker->numberBetween([1000000, 1500000]),
            'versement' => $this->faker->numberBetween([1000000, 1500000]),
            'reste' => 1500000,
            'user_id' => User::all()->random()->id,
            'annee_academique_id' => AnneeAcademique::all()->random()->id,
        ];
    }
}
