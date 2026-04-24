<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Personnel;   // ✅ import du modèle
use App\Models\Ec;          // si tu as un modèle Ec

class EnseigneFactory extends Factory
{
    public function definition(): array
    {
        return [
            'code_ec' => Ec::inRandomOrder()->first()?->code_ec, // cohérent avec ta table EC
            'code_personnel' => Personnel::inRandomOrder()->first()?->code_personnel, // cohérent avec ta table Personnel
        ];
    }
}
