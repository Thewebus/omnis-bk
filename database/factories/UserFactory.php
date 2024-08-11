<?php

namespace Database\Factories;

use App\Models\Classe;
use App\Models\NiveauFaculte;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fullname' => $this->faker->name(),
            'date_naissance' => now(),
            'lieu_naissance' => $this->faker->city(),
            'numero_etudiant' => $this->faker->unique()->randomNumber(5, true),
            'email' => $this->faker->unique()->safeEmail(),
            'cursus' => $this->faker->randomElement(['jour', 'soir']),
            'sexe' => $this->faker->randomElement(['masculin', 'feminin']),
            'statut' => $this->faker->randomElement(['affecté', 'non affecté', 'réaffecté']),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            // 'parent' => $this->faker->unique()->randomNumber(5, true),
            // 'fixe' => $this->faker->unique()->randomNumber(5, true),
            // 'postale' => $this->faker->bothify('??????-######'),
            // 'code_etudiant' => $this->faker->numerify('CDETD-#########'),
            'matricule_etudiant' => $this->faker->randomNumber(8, true),
            'niveau_faculte_id' => NiveauFaculte::all()->random()->id,
            'classe_id' => Classe::all()->random()->id,
            // 'classe_id' => Classe::all()->random()->id,
            'remember_token' => Str::random(10),
        ];

        // $users = [
        //     [
        //         'fullname' => 'Super Sidick',
        //         'email' => 'azerty@test.com',
        //         'email_verified_at' => now(),
        //         'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //         'remember_token' => Str::random(10),
        //     ],
        //     [
        //         'fullname' => 'Autre testeur',
        //         'email' => 'test@test.com',
        //         'email_verified_at' => now(),
        //         'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //         'remember_token' => Str::random(10),
        //     ]
        // ];

        // foreach ($users as $user) {
        //     User::create($user);
        // }

        // return [
        //     'fullname' => 'Super Sidick',
        //     'email' => 'etudiant@test.com',
        //     'email_verified_at' => now(),
        //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //     'remember_token' => Str::random(10),
        // ];

        // return [
        //     'fullname' => 'Super Sidick',
        //     'numero' => $this->faker->unique()->randomNumber(5, true),
        //     'parent' => $this->faker->unique()->randomNumber(5, true),
        //     'fixe' => $this->faker->unique()->randomNumber(5, true),
        //     'postale' => $this->faker->bothify('??????-######'),
        //     'email' => 'azerty@test.com',
        //     'cursus' => $this->faker->randomElement(['jour', 'soir']),
        //     'email_verified_at' => now(),
        //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //     'code_inscription' => $this->faker->numerify('code-#########'),
        //     'filiere_id' => Filiere::all()->random()->id,
        //     'classe_id' => Classe::all()->random()->id,
        //     'remember_token' => Str::random(10),
        // ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
