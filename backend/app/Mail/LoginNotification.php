<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Personnel;

class LoginNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $personnel;
    // now keep plain password (requested) -- WARNING: insecure in production
    public $plainPassword;
    public $maskedPassword;

    /**
     * Create a new message instance.
     */
    public function __construct(Personnel $personnel, string $plainPassword)
    {
        $this->personnel = $personnel;
        $this->plainPassword = $plainPassword;
        // Mask password: show only last 2 characters
        $this->maskedPassword = str_repeat('*', max(0, strlen($plainPassword) - 2)) . substr($plainPassword, -2);
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Connexion réussie')
                    ->view('emails.auth.login');
    }
}
