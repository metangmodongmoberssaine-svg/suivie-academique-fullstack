<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Ec;
use App\Models\Personnel;
use App\Models\Enseigne;
use Laravel\Sanctum\Sanctum;

class EnseigneTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_enseignes(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // Créer EC et Personnel pour respecter les exists (codes uniques pour cette suite)
        Ec::factory()->create(['code_ec' => 'EC_ENS_GET_1']);
        Personnel::factory()->create(['code_personnel' => 'PERS_ENS_GET_1']);

        Enseigne::factory()->create([
            'code_personnel' => 'PERS_ENS_GET_1',
            'code_ec'        => 'EC_ENS_GET_1',
        ]);

        $response = $this->getJson('/api/enseignes');

        $response->assertStatus(200)
                 ->assertJsonFragment(['code_personnel' => 'PERS_ENS_GET_1']);
    }

    public function test_create_enseigne(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // Préparer FKs (valeurs uniques)
        Ec::factory()->create(['code_ec' => 'EC_ENS_CREATE_1']);
        Personnel::factory()->create(['code_personnel' => 'PERS_ENS_CREATE_1']);

        $data = [
            'code_personnel' => 'PERS_ENS_CREATE_1',
            'code_ec'        => 'EC_ENS_CREATE_1',
        ];

        $response = $this->postJson('/api/enseignes', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['code_personnel' => 'PERS_ENS_CREATE_1']);

        $this->assertDatabaseHas('enseigne', $data);
    }

    public function test_update_enseigne(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // FKs existants (utiliser codes uniques pour éviter collisions entre tests)
        Ec::factory()->create(['code_ec' => 'EC_ENS_UPD_OLD']);
        Ec::factory()->create(['code_ec' => 'EC_ENS_UPD_NEW']); // nouvelle valeur de mise à jour
        Personnel::factory()->create(['code_personnel' => 'PERS_ENS_UPD']);

        // Enregistrement initial
        Enseigne::factory()->create([
            'code_personnel' => 'PERS_ENS_UPD',
            'code_ec'        => 'EC_ENS_UPD_OLD',
        ]);

        $payload = ['code_ec' => 'EC_ENS_UPD_NEW'];

        // Route composite
        $response = $this->putJson('/api/enseignes/EC_ENS_UPD_OLD/PERS_ENS_UPD', $payload);

        $response->assertStatus(200)
                 ->assertJsonFragment(['code_ec' => 'EC_ENS_UPD_NEW']);

        $this->assertDatabaseHas('enseigne', [
            'code_personnel' => 'PERS_ENS_UPD',
            'code_ec'        => 'EC_ENS_UPD_NEW',
        ]);
    }

    public function test_delete_enseigne(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // FKs existants (valeurs uniques)
        Ec::factory()->create(['code_ec' => 'EC_ENS_DEL']);
        Personnel::factory()->create(['code_personnel' => 'PERS_ENS_DEL']);

        // Enregistrement à supprimer
        Enseigne::factory()->create([
            'code_personnel' => 'PERS_ENS_DEL',
            'code_ec'        => 'EC_ENS_DEL',
        ]);

        // Route composite
        $response = $this->deleteJson('/api/enseignes/EC_ENS_DEL/PERS_ENS_DEL');

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Suppression réussie']);

        $this->assertDatabaseMissing('enseigne', [
            'code_personnel' => 'PERS_ENS_DEL',
            'code_ec'        => 'EC_ENS_DEL',
        ]);
    }
}
