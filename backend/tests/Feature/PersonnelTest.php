<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Personnel;
use Laravel\Sanctum\Sanctum;

class PersonnelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test GET /api/personnel
     */
    public function test_get_personnel(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        Personnel::factory()->create([
            'code_personnel' => 'PERS2001',
            'nom_personnel' => 'Doe',
            'sex_personnel' => 'M',
            'phone_personnel' => '612345678',
            'login_personnel' => 'doe.j',
            'password_personnel' => bcrypt('secret'),
            'type_personnel' => 'ENSEIGNANT',
        ]);

        $response = $this->getJson('/api/personnels');

        $response->assertStatus(200)
                 ->assertJsonFragment(['code_personnel' => 'PERS2001']);
    }

    /**
     * Test POST /api/personnel
     */
    public function test_create_personnel(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $data = [
            'code_personnel'     => 'PERS1001',
            'nom_personnel'      => 'Smith',
            'sex_personnel'      => 'F',
            'phone_personnel'    => '612345679',
            'login_personnel'    => 'smith.a',
            'password_personnel' => 'secret123',
            'type_personnel'     => 'RESPONSABLE_ACADEMIQUE',
        ];

        $response = $this->postJson('/api/personnels', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['code_personnel' => 'PERS1001']);

        $this->assertDatabaseHas('personnel', [
            'code_personnel' => 'PERS1001',
            'nom_personnel'  => 'Smith',
            'type_personnel' => 'RESPONSABLE_ACADEMIQUE'
        ]);
    }

    /**
     * Test PUT /api/personnel/{code}
     */
    public function test_update_personnel(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $personnel = Personnel::factory()->create([
            'code_personnel'     => 'PERS3001',
            'nom_personnel'      => 'Ancien',
            'sex_personnel'      => 'M',
            'phone_personnel'    => '679999999',
            'login_personnel'    => 'ancien.n',
            'password_personnel' => bcrypt('secret'),
            'type_personnel'     => 'ENSEIGNANT',
        ]);

        $payload = ['type_personnel' => 'RESPONSABLE_FINANCIER'];

        $response = $this->putJson('/api/personnels/' . $personnel->code_personnel, $payload);

        $response->assertStatus(200)
                 ->assertJsonFragment(['type_personnel' => 'RESPONSABLE_FINANCIER']);

        $this->assertDatabaseHas('personnel', array_merge(['code_personnel' => $personnel->code_personnel], $payload));
    }

    /**
     * Test DELETE /api/personnel/{code}
     */
    public function test_delete_personnel(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $personnel = Personnel::factory()->create([
            'code_personnel'     => 'PERS4001',
            'nom_personnel'      => 'À supprimer',
            'sex_personnel'      => 'F',
            'phone_personnel'    => '600000001',
            'login_personnel'    => 'asup.pr',
            'password_personnel' => bcrypt('secret'),
            'type_personnel'     => 'ENSEIGNANT',
        ]);

        $response = $this->deleteJson('/api/personnels/' . $personnel->code_personnel);

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Suppression réussie']);

        $this->assertDatabaseMissing('personnel', ['code_personnel' => 'PERS4001']);
    }
}
