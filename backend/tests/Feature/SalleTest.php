<?php

namespace Tests\Feature;

use App\Models\Salle;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SalleTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_salles()
    {
        $user = User::factory()->create();

        Salle::factory()->create();
        Salle::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/salles');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
    }

    public function test_store_creates_salle()
    {
        $user = User::factory()->create();

        $payload = [
            'contenance' => 120,
            'status'     => 'libre',
        ];

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/salles', $payload);

        $response->assertStatus(201);
        $this->assertDatabaseHas('salle', ['contenance' => (string) $payload['contenance'], 'status' => $payload['status']]);
    }

    public function test_show_returns_salle()
    {
        $user = User::factory()->create();

        $salle = Salle::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/salles/'.$salle->id);

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $salle->id]);
    }

    public function test_update_modifies_salle()
    {
        $user = User::factory()->create();

        $salle = Salle::factory()->create(['status' => 'libre']);

        $response = $this->actingAs($user, 'sanctum')->putJson('/api/salles/'.$salle->id, [
            'status' => 'occupée'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('salle', ['id' => $salle->id, 'status' => 'occupée']);
    }

    public function test_delete_removes_salle()
    {
        $user = User::factory()->create();

        $salle = Salle::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->deleteJson('/api/salles/'.$salle->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('salle', ['id' => $salle->id]);
    }
}
