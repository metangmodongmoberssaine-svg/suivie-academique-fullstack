<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Filiere;

class FiliereCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $filiere;

    /**
     * Create a new message instance.
     */
    public function __construct(Filiere $filiere)
    {
        $this->filiere = $filiere;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this
            ->subject("Nouvelle filière créée: {$this->filiere->label_filiere}")
            ->view('emails.filieres.created');
    }
}
