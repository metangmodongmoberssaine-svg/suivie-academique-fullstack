<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTestMail extends Command
{
    protected $signature = 'mail:test {--email=}';

    protected $description = 'Envoyer un mail de test (Mailpit)';

    public function handle()
    {
        $email = $this->option('email') ?? config('mail.from.address');
        $filiere = \App\Models\Filiere::latest()->first() ?? \App\Models\Filiere::factory()->create();

        try {
            Mail::to($email)->send(new \App\Mail\FiliereCreated($filiere));
            $this->info("Mail envoyé à {$email}");
            return 0;
        } catch (\Throwable $e) {
            $this->error('Erreur envoi mail: ' . $e->getMessage());
            return 1;
        }
    }
}
