<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Salle;
use App\Models\Ec;
use App\Models\Personnel;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Programme>
 */
class ProgrammeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Références (tu peux adapter selon tes autres factories)
            'code_ec'        => Ec::factory()->create()->code_ec,
            'salle_id'       => Salle::factory(),
            'code_personnel' => Personnel::factory()->create()->code_personnel,

            // Champs de la migration
            'date'           => $this->faker->date(),
            'heure_debut'    => $this->faker->time('H:i'),
            'heure_fin'      => $this->faker->time('H:i'),
            'nombre_dheure'  => $this->faker->numberBetween(1, 4),
            'statut'         => $this->faker->randomElement(['validé', 'en attente', 'annulé']),
        ];
    }
}
