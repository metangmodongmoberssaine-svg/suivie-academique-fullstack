<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Ue;
use App\Models\Niveau;
use Laravel\Sanctum\Sanctum;

class UeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test GET /api/ue
     */
    public function test_get_ues(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $niveau = Niveau::factory()->create(['code_niveau' => 'NIV9001']);

        Ue::factory()->create([
            'code_ue' => 'UE2001',
            'label_ue' => 'Mathématiques',
            'description_ue' => 'Unité d’enseignement de base en mathématiques',
            'code_niveau' => $niveau->code_niveau,
        ]);

        $response = $this->getJson('/api/ues');

        $response->assertStatus(200)
                 ->assertJsonFragment(['code_ue' => 'UE2001']);
    }

    /**
     * Test POST /api/ue
     */
    public function test_create_ue(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $niveau = Niveau::factory()->create(['code_niveau' => 'NIV9002']);

        $data = [
            'code_ue' => 'UE1001',
            'label_ue' => 'Informatique',
            'description_ue' => 'Unité d’enseignement en informatique',
            'code_niveau' => $niveau->code_niveau,
        ];

        $response = $this->postJson('/api/ues', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['code_ue' => 'UE1001']);

        $this->assertDatabaseHas('ues', $data);
    }

    /**
     * Test PUT /api/ue/{code}
     */
    public function test_update_ue(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $niveau = Niveau::factory()->create(['code_niveau' => 'NIV9003']);

        $ue = Ue::factory()->create([
            'code_ue' => 'UE3001',
            'label_ue' => 'Ancien Label',
            'description_ue' => 'Description initiale',
            'code_niveau' => $niveau->code_niveau,
        ]);

        $payload = ['label_ue' => 'Nouveau Label'];

        $response = $this->putJson('/api/ues/' . $ue->code_ue, $payload);

        $response->assertStatus(200)
                 ->assertJsonFragment(['label_ue' => 'Nouveau Label']);

        $this->assertDatabaseHas('ues', array_merge(['code_ue' => $ue->code_ue], $payload));
    }

    /**
     * Test DELETE /api/ue/{code}
     */
    public function test_delete_ue(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $niveau = Niveau::factory()->create(['code_niveau' => 'NIV9004']);

        $ue = Ue::factory()->create([
            'code_ue' => 'UE4001',
            'label_ue' => 'À supprimer',
            'description_ue' => 'Description',
            'code_niveau' => $niveau->code_niveau,
        ]);

        $response = $this->deleteJson('/api/ues/' . $ue->code_ue);

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Suppression réussie']);

        $this->assertDatabaseMissing('ues', ['code_ue' => 'UE4001']);
    }
}
