<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Ue;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ec>
 */
class EcFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code_ec' => $this->faker->unique()->bothify('EC####'),
            'label_ec' => $this->faker->words(3, true),
            'description_ec' => $this->faker->sentence(),
            'code_ue' => Ue::factory()->create()->code_ue,
            'nb_heures_ec' => $this->faker->numberBetween(10, 100),
            'nb_credit_ec' => $this->faker->numberBetween(1, 10),
        ];
    }
}
