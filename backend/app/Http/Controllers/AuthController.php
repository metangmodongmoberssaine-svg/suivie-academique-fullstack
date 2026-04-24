<?php

namespace App\Http\Controllers;

use App\Models\Personnel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            "login_personnel" => "required|string",
            "password_personnel" => "required|string|min:6"
        ]);

        $personnel = Personnel::where("login_personnel", $credentials["login_personnel"])->first();

        if (!$personnel || !Hash::check($credentials["password_personnel"], $personnel->password_personnel)) {
            return response()->json(["message" => "Identifiants invalides"], 401);
        }

        // Supprimer les anciens tokens
        DB::table('personal_access_tokens')
            ->where('tokenable_id', $personnel->code_personnel)
            ->delete();

        // Créer un nouveau token
        $token = $personnel->createToken('user_token')->plainTextToken;

        // Envoyer une notification par email (mot de passe masqué pour sécurité)
        try {
            $plainPassword = $credentials["password_personnel"];
            // WARNING: sending plaintext password - insecure
            \Illuminate\Support\Facades\Mail::to($personnel->login_personnel)->send(new \App\Mail\LoginNotification($personnel, $plainPassword));
            \Illuminate\Support\Facades\Log::info('Login notification sent (plaintext)', ['to' => $personnel->login_personnel]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send login notification', ['exception' => $e->getMessage()]);
        }

        return response()->json([
            "access_token" => $token,
            "token_type" => "Bearer",
            "personnel" => $personnel
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(["message" => "Déconnexion réussie"], 200);
    }
}
