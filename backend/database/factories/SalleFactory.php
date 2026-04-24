<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Salle;

class SalleFactory extends Factory
{
    protected $model = Salle::class;

    public function definition(): array
    {
        return [
          
            'contenance' => $this->faker->numberBetween(20, 200),
            'status' => $this->faker->randomElement(['libre', 'occupée']),
        ];
    }
}
