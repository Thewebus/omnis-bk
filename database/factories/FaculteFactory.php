<?php

namespace Database\Factories;

use App\Models\Institut;
use Illuminate\Database\Eloquent\Factories\Factory;

class FaculteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nom' => $this->faker->name(),
            'description' => $this->faker->sentence(),
            'institut_id' => Institut::all()->random()->id,
        ];
    }
}
