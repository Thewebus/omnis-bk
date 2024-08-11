<?php

namespace Database\Factories;

use App\Models\AnneeAcademique;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Note;
use App\Models\Professeur;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Note::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $note_1 = $this->faker->randomFloat(2, 0, 20);
        $note_2 = $this->faker->randomFloat(2, 0, 20);
        $note_3 = $this->faker->randomFloat(2, 0, 20);
        $moyenne = ($note_1 + $note_2 + $note_3) / 3;
        $partiel =  $this->faker->randomFloat(2, 0, 20);
        $note_finale = ($moyenne * 0.4) + ($partiel * 0.6);

        return [
            'note_1' => $note_1,
            'note_2' => $note_2,
            'note_3' => $note_3,
            'nbr_note' => $this->faker->numberBetween(0, 3),
            'moyenne' => $moyenne,
            'partiel_session_1' =>  $partiel,
            // 'partiel_session_2' =>  $partiel,
            'status' => $note_finale > 10 ? 'admis' : 'ajourné',
            'classe_id' => Classe::all()->random()->id,
            'matiere_id' => Matiere::all()->random()->id,
            'user_id' => User::all()->random()->id,
            'professeur_id' => Professeur::all()->random()->id,
            'annee_academique_id' => AnneeAcademique::all()->random()->id,
        ];
    }
}
