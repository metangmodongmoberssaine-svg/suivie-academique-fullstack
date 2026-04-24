<?php

namespace Tests\Feature;

use App\Models\Programme;
use App\Models\Salle;
use App\Models\Ec;
use App\Models\Personnel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class ProgrammeTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_programmes()
    {
        $user = User::factory()->create();

        Programme::factory()->create();
        Programme::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/programmes');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
    }

    public function test_store_creates_programme()
    {
        $user = User::factory()->create();

        $ec = Ec::factory()->create();
        $personnel = \App\Models\Personnel::factory()->create();
        $payload = [
            'code_ec'         => $ec->code_ec,
            'salle_id'        => Salle::factory()->create()->id,
            'code_personnel'  => $personnel->code_personnel,
            'date'            => now()->toDateString(),
            'heure_debut'     => '08:00',
            'heure_fin'       => '10:00',
            'nombre_dheure'   => 2,
            'statut'          => 'validé',
        ];

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/programmes', $payload);

        $response->assertStatus(201);
        $this->assertDatabaseHas('programmes', ['code_ec' => $payload['code_ec'], 'salle_id' => $payload['salle_id']]);
    }

    public function test_show_returns_programme()
    {
        $user = User::factory()->create();

        $programme = Programme::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/programmes/'.$programme->id);

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $programme->id]);
    }

    public function test_update_modifies_programme()
    {
        $user = User::factory()->create();

        $programme = Programme::factory()->create(['statut' => 'en attente']);

        $response = $this->actingAs($user, 'sanctum')->putJson('/api/programmes/'.$programme->id, [
            'statut' => 'annulé'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('programmes', ['id' => $programme->id, 'statut' => 'annulé']);
    }

    public function test_delete_removes_programme()
    {
        $user = User::factory()->create();

        $programme = Programme::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->deleteJson('/api/programmes/'.$programme->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('programmes', ['id' => $programme->id]);
    }
}
