<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Ec;
use App\Models\Ue;
use Laravel\Sanctum\Sanctum;

class EcTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_ecs(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $ue = Ue::factory()->create(['code_ue' => 'UE5001']);

        Ec::factory()->create([
            'code_ec' => 'EC2001',
            'label_ec' => 'Programmation',
            'description_ec' => 'Cours de programmation',
            'nb_heures_ec' => 30,
            'nb_credit_ec' => 6,
            'code_ue' => $ue->code_ue,
        ]);

        $response = $this->getJson('/api/ecs');

        $response->assertStatus(200)
                 ->assertJsonFragment(['code_ec' => 'EC2001']);
    }

    public function test_create_ec(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $ue = Ue::factory()->create(['code_ue' => 'UE5002']);

        $data = [
            'code_ec' => 'EC1001',
            'label_ec' => 'Analyse',
            'description_ec' => 'Cours d’analyse mathématique',
            'nb_heures_ec' => 40,
            'nb_credit_ec' => 8,
            'code_ue' => $ue->code_ue,
        ];

        $response = $this->postJson('/api/ecs', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['code_ec' => 'EC1001']);

        $this->assertDatabaseHas('ecs', $data);
    }

    public function test_update_ec(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $ue = Ue::factory()->create(['code_ue' => 'UE5003']);

        $ec = Ec::factory()->create([
            'code_ec' => 'EC3001',
            'label_ec' => 'Ancien Label',
            'description_ec' => 'Description initiale',
            'nb_heures_ec' => 20,
            'nb_credit_ec' => 4,
            'code_ue' => $ue->code_ue,
        ]);

        $payload = ['label_ec' => 'Nouveau Label'];

        $response = $this->putJson('/api/ecs/' . $ec->code_ec, $payload);

        $response->assertStatus(200)
                 ->assertJsonFragment(['label_ec' => 'Nouveau Label']);

        $this->assertDatabaseHas('ecs', array_merge(['code_ec' => $ec->code_ec], $payload));
    }

    public function test_delete_ec(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $ue = Ue::factory()->create(['code_ue' => 'UE5004']);

        $ec = Ec::factory()->create([
            'code_ec' => 'EC4001',
            'label_ec' => 'À supprimer',
            'description_ec' => 'Description',
            'nb_heures_ec' => 10,
            'nb_credit_ec' => 2,
            'code_ue' => $ue->code_ue,
        ]);

        $response = $this->deleteJson('/api/ecs/' . $ec->code_ec);

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Suppression réussie']);

        $this->assertDatabaseMissing('ecs', ['code_ec' => 'EC4001']);
    }
}
