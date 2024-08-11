<?php

namespace Database\Factories;

use App\Models\Professeur;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfesseurFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Professeur::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fullname' => $this->faker->name,
            'numero' => $this->faker->unique()->randomNumber(5, true),
            'email' => $this->faker->unique()->safeEmail(),
            'taux_horaire_bts' => $this->faker->numberBetween(5000, 10000),
            'taux_horaire_licence' => $this->faker->numberBetween(5000, 10000),
            'taux_horaire_master' => $this->faker->numberBetween(5000, 10000),
            'statut' => $this->faker->randomElement(['salarié', 'fonctionnaire']),
            'email_verified_at' => now(),
            'valide' => $this->faker->randomElement([0, 1]),
            'remember_token' => Str::random(10),
            'type' => 'professeur',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ];
    }
}
