<?php

namespace Database\Factories;

use App\Models\AnneeAcademique;
use App\Models\Classe;
use App\Models\NiveauFaculte;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClasseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Classe::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nom' => $this->faker->unique()->word,
            'code' => $this->faker->unique()->word,
            'description' => $this->faker->sentence(),
            'niveau_faculte_id' => NiveauFaculte::all()->random()->id,
        ];
    }
}
