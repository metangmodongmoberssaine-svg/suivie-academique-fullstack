<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use App\Mail\FiliereCreated;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MailTest extends TestCase
{
    use RefreshDatabase;

    public function test_mail_is_sent_on_filiere_creation()
    {
        Mail::fake();

        $payload = [
            'code_filiere' => 'TST12345',
            'label_filiere' => 'Test Mail',
            'description_filiere' => 'Test envoi mail'
        ];

        $this->postJson('/api/filieres', $payload)
            ->assertStatus(201);

        Mail::assertSent(FiliereCreated::class, function ($mail) {
            return $mail->hasTo(config('mail.from.address'));
        });
    }
}
