<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FiliereController;
use App\Http\Controllers\NiveauController;

Route::get('/', function () {
    return view('welcome');
});

// Route de test pour envoyer un email via Mailpit
Route::get('/test-mail', function() {
    $filiere = App\Models\Filiere::latest()->first() ?? App\Models\Filiere::factory()->create();
    try {
        Illuminate\Support\Facades\Mail::to(config('mail.from.address'))->send(new App\Mail\FiliereCreated($filiere));
        return 'Mail envoyé à ' . config('mail.from.address');
    } catch (\Throwable $e) {
        return 'Erreur envoi mail: ' . $e->getMessage();
    }
});



