<?php

namespace App\Http\Controllers;

use App\Models\Enseigne;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EnseigneController extends Controller
{
    /**
     * Liste des enseignements
     */
    public function index()
    {
        return response()->json(Enseigne::all(), 200);
    }

    /**
     * Création
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'code_ec'        => 'required|string|exists:ecs,code_ec',
                'code_personnel' => 'required|string|exists:personnel,code_personnel',
            ]);

            // Empêcher les doublons exacts
            $exists = Enseigne::where('code_ec', $validated['code_ec'])
                ->where('code_personnel', $validated['code_personnel'])
                ->exists();

            if ($exists) {
                return response()->json(['message' => 'Enseigne déjà existant'], 409);
            }

            $enseigne = Enseigne::create($validated);

            return response()->json([
                'message' => 'Enseigne créé avec succès',
                'data'    => $enseigne
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    /**
     * Affichage par clé composite
     */
    public function show(string $code_ec, string $code_personnel)
    {
        try {
            $enseigne = Enseigne::where('code_ec', $code_ec)
                ->where('code_personnel', $code_personnel)
                ->firstOrFail();

            return response()->json($enseigne, 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Enseigne non trouvé'], 404);
        }
    }

    /**
     * Mise à jour par clé composite
     * (utilise le Query Builder pour éviter la dépendance à une clé primaire Eloquent)
     */
    public function update(Request $request, string $code_ec, string $code_personnel)
    {
        try {
            // Vérifier existence
            $exists = Enseigne::where('code_ec', $code_ec)
                ->where('code_personnel', $code_personnel)
                ->exists();

            if (! $exists) {
                return response()->json(['message' => 'Enseigne non trouvé'], 404);
            }

            $validated = $request->validate([
                'code_ec'        => 'sometimes|string|exists:ecs,code_ec',
                'code_personnel' => 'sometimes|string|exists:personnel,code_personnel',
            ]);

            // Mettre à jour
            Enseigne::where('code_ec', $code_ec)
                ->where('code_personnel', $code_personnel)
                ->update($validated);

            // Retourner la ressource mise à jour
            $updated = Enseigne::where('code_ec', $validated['code_ec'] ?? $code_ec)
                ->where('code_personnel', $validated['code_personnel'] ?? $code_personnel)
                ->first();

            return response()->json([
                'message' => 'Enseigne mis à jour avec succès',
                'data'    => $updated
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    /**
     * Suppression par clé composite
     */
    public function destroy(string $code_ec, string $code_personnel)
    {
        try {
            $deleted = Enseigne::where('code_ec', $code_ec)
                ->where('code_personnel', $code_personnel)
                ->delete();

            if ($deleted === 0) {
                return response()->json(['message' => 'Enseigne non trouvé'], 404);
            }

            return response()->json(['message' => 'Suppression réussie'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
