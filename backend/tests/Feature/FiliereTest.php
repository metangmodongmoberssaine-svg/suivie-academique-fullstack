<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Filiere;
use Laravel\Sanctum\Sanctum;

class FiliereTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test GET /api/filieres
     */
    public function test_get_filieres(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        Filiere::factory()->create([
            'code_filiere' => 'FIL2001',
            'label_filiere' => 'Informatique',
        ]);

        $response = $this->getJson('/api/filieres');

        $response->assertStatus(200)
                 ->assertJsonFragment(['code_filiere' => 'FIL2001']);
    }

    /**
     * Test POST /api/filieres en utilisant Sanctum::actingAs
     */
    public function test_create_filiere_with_sanctum(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

     $data = [
    'code_filiere' => 'FIL1001',
    'label_filiere' => 'Génie Logiciel',
    'description_filiere' => 'Formation en développement logiciel',
];

        $response = $this->postJson('/api/filieres', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['code_filiere' => 'FIL1001']);

        $this->assertDatabaseHas('filieres', $data);
    }

    /**
     * Test POST /api/filieres en utilisant un Bearer token (simule votre flux en prod)
     */
    public function test_create_filiere_with_bearer_token(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $data = [
            'code_filiere' => 'FIL1002',
            'label_filiere' => 'Réseaux',
            'description_filiere' => 'Formation en réseaux et télécoms',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/filieres', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['code_filiere' => 'FIL1002']);

        $this->assertDatabaseHas('filieres', $data);
    }

    /**
     * Test PUT /api/filieres/{code}
     */
    public function test_update_filiere(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $filiere = Filiere::factory()->create([
            'code_filiere' => 'FIL3001',
            'label_filiere' => 'Ancien Label',
            'description_filiere' => 'Description initiale',
        ]);

        $payload = [
            'label_filiere' => 'Nouveau Label',
        ];

        $response = $this->putJson('/api/filieres/' . $filiere->code_filiere, $payload);

        $response->assertStatus(200)
                 ->assertJsonFragment(['label_filiere' => 'Nouveau Label']);

        $this->assertDatabaseHas('filieres', array_merge(['code_filiere' => $filiere->code_filiere], $payload));
    }

    /**
     * Test DELETE /api/filieres/{code}
     */
    public function test_delete_filiere(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $filiere = Filiere::factory()->create([
            'code_filiere' => 'FIL4001',
            'label_filiere' => 'À supprimer',
            'description_filiere' => 'Description',
        ]);

        $response = $this->deleteJson('/api/filieres/' . $filiere->code_filiere);

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Suppression réussie']);

        $this->assertDatabaseMissing('filieres', ['code_filiere' => $filiere->code_filiere]);
    }
}
