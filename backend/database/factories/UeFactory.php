<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Niveau;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ue>
 */
class UeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code_ue' => $this->faker->unique()->bothify('UE####'),
            'label_ue' => $this->faker->words(3, true),
            'description_ue' => $this->faker->sentence(),
            'code_niveau' => Niveau::inRandomOrder()->first()?->code_niveau ?? Niveau::factory()->create()->code_niveau,
        ];
    }
}
