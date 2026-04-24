<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Niveau;
use App\Models\Filiere;

class NiveauFactory extends Factory
{
    protected $model = Niveau::class;

    public function definition(): array
    {
        return [
            'code_niveau' => $this->faker->unique()->bothify('NIV####'),
            'label_niveau' => $this->faker->words(2, true),
            'description_niveau' => $this->faker->paragraph(),
            'code_filiere' => Filiere::inRandomOrder()->first()?->code_filiere ?? Filiere::factory()->create()->code_filiere,
        ];

    }
}
