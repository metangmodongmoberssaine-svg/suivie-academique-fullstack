<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\Personnel;
use App\Mail\LoginNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginMailTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_sends_notification_email_with_masked_password()
    {
        Mail::fake();

        $password = 'secret123';
        $personnel = Personnel::factory()->create([
            'login_personnel' => 'dev@example.com',
            'password_personnel' => Hash::make($password),
            'nom_personnel' => 'Test User'
        ]);

        $payload = [
            'login_personnel' => 'dev@example.com',
            'password_personnel' => $password
        ];

        $this->postJson('/api/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure(['access_token','token_type','personnel']);

        $masked = str_repeat('*', max(0, strlen($password)-2)) . substr($password, -2);

        Mail::assertSent(LoginNotification::class, function ($mail) use ($personnel, $masked) {
            return $mail->hasTo($personnel->login_personnel) && $mail->maskedPassword === $masked;
        });
    }
}
