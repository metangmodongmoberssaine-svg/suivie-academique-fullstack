<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Personnel>
 */
class PersonnelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code_personnel'     => $this->faker->unique()->bothify('PERS#####'),
            'nom_personnel'      => $this->faker->lastName(),
            'login_personnel'    => $this->faker->userName(),
            'password_personnel' => bcrypt('password'),
            // ✅ uniquement des chiffres pour coller au type INT
            'phone_personnel'    => $this->faker->numerify('6########'),
            'sex_personnel'      => $this->faker->randomElement(['M', 'F']),
            'type_personnel'     => $this->faker->randomElement([
                'ENSEIGNANT',
                'RESPONSABLE_ACADEMIQUE',
                'RESPONSABLE_FINANCIER'
            ]),
        ];
    }
}
