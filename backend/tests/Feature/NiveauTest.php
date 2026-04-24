<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Niveau;
use App\Models\Filiere;
use Laravel\Sanctum\Sanctum;

class NiveauTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test GET /api/niveaux
     */
    public function test_get_niveaux(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $filiere = Filiere::factory()->create([
            'code_filiere' => 'FIL5001',
        ]);

        Niveau::factory()->create([
            'code_niveau' => 'NIV2001',
            'label_niveau' => 'Licence 1',
            'code_filiere' => $filiere->code_filiere,
        ]);

        $response = $this->getJson('/api/niveaux');

        $response->assertStatus(200)
                 ->assertJsonFragment(['code_niveau' => 'NIV2001']);
    }

    /**
     * Test POST /api/niveaux
     */
    public function test_create_niveau(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $filiere = Filiere::factory()->create([
            'code_filiere' => 'FIL6001',
        ]);

        $data = [
            'code_niveau' => 'NIV1001',
            'label_niveau' => 'Master 1',
            'description_niveau' => 'Première année du cycle Master',
            'code_filiere' => $filiere->code_filiere,
        ];

        $response = $this->postJson('/api/niveaux', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['code_niveau' => 'NIV1001']);

        $this->assertDatabaseHas('niveaux', $data);
    }

    /**
     * Test PUT /api/niveaux/{code}
     */
    public function test_update_niveau(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $filiere = Filiere::factory()->create([
            'code_filiere' => 'FIL7001'
        ]);

        $niveau = Niveau::factory()->create([
            'code_niveau' => 'NIV3001',
            'label_niveau' => 'Ancien Label',
            'description_niveau' => 'Description initiale',
            'code_filiere' => $filiere->code_filiere,
        ]);

        $payload = [
            'label_niveau' => 'Nouveau Label',
        ];

        $response = $this->putJson('/api/niveaux/' . $niveau->code_niveau, $payload);

        $response->assertStatus(200)
                 ->assertJsonFragment(['label_niveau' => 'Nouveau Label']);

        $this->assertDatabaseHas('niveaux', array_merge(['code_niveau' => $niveau->code_niveau], $payload));
    }

    /**
     * Test DELETE /api/niveaux/{code}
     */
    public function test_delete_niveau(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $filiere = Filiere::factory()->create([
            'code_filiere' => 'FIL8001'
        ]);

        $niveau = Niveau::factory()->create([
            'code_niveau' => 'NIV4001',
            'label_niveau' => 'À supprimer',
            'description_niveau' => 'Description',
            'code_filiere' => $filiere->code_filiere,
        ]);

        $response = $this->deleteJson('/api/niveaux/' . $niveau->code_niveau);

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Suppression réussie']);

        $this->assertDatabaseMissing('niveaux', ['code_niveau' => $niveau->code_niveau]);
    }
}
