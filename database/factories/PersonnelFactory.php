<?php

namespace Database\Factories;

use App\Models\Personnel;
use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonnelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Personnel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // return [
        //     'fullname' => $this->faker->name,
        //     'numero' => $this->faker->unique()->randomNumber(10, true),
        //     'email' => $this->faker->unique()->safeEmail(),
        //     'email_verified_at' => now(),
        //     'remember_token' => Str::random(10),
        //     'type' => $this->faker->word(),
        //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //     'poste_id' => Poste::all()->random()->id,
        // ];

        return [
            'fullname' => 'Personnel tester',
            'numero' => $this->faker->unique()->randomNumber(5, true),
            'email' => 'personnel@test.com',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'type' => 'personnel',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'service_id' => Service::all()->random()->id,
        ];
    }
}
