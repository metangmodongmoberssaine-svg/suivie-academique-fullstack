<?php

namespace App\Http\Controllers;

use App\Models\Ue;
use Illuminate\Http\Request;

class UeController extends Controller
{
    /**
     * Affiche la liste de toutes les UE.
     */
    public function index()
    {
        $ues = Ue::all();
        return response()->json($ues, 200);
    }

    /**
     * Enregistre une nouvelle UE.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'code_ue'        => 'required|string|min:3|unique:ues,code_ue',
                'label_ue'       => 'required|string|min:5',
                'description_ue' => 'required|string|min:5',
                 'code_niveau'    => 'required|string|exists:niveaux,code_niveau',

            ]);

            $ue = Ue::create($validatedData);

            return response()->json([
                "message" => "UE créée avec succès",
                "data"    => $ue
            ], 201);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Affiche une UE spécifique.
     */
    public function show(string $code_ue)
    {
        try {
            $ue = Ue::findOrFail($code_ue);
            return response()->json($ue, 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "UE non trouvée"], 404);
        }
    }

    /**
     * Met à jour une UE existante.
     */
    public function update(Request $request, string $code_ue)
    {
        try {
            $ue = Ue::findOrFail($code_ue);

            $validatedData = $request->validate([
                'label_ue'       => 'sometimes|string|min:5',
                'description_ue' => 'sometimes|string|min:5',
            ]);

            $ue->update($validatedData);

            return response()->json([
                "message" => "UE mise à jour avec succès",
                "data"    => $ue
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Supprime une UE selon son code.
     */
    public function destroy(string $code_ue)
    {
        try {
            $ue = Ue::findOrFail($code_ue);
            $ue->delete();

            return response()->json([
                "message" => "Suppression réussie"
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "UE non trouvée"
            ], 404);
        }
    }
}
