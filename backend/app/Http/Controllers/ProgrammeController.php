<?php

namespace App\Http\Controllers;

use App\Models\Programme;
use Illuminate\Http\Request;

class ProgrammeController extends Controller
{
    /**
     * Affiche tous les programmes.
     */
    public function index()
    {
        $programmes = Programme::all();
        return response()->json($programmes, 200);
    }

    /**
     * Enregistre un nouveau programme.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'code_ec'        => 'required|string|min:5',
                'salle_id'        => 'required|integer|exists:salle,id',
                'code_personnel' => 'required|string|min:3',
                'date'           => 'required|date',
                'heure_debut'    => 'required|date_format:H:i',
                'heure_fin'      => 'required|date_format:H:i',
                'nombre_dheure'  => 'required|integer|min:1',
                'statut'         => 'required|string'
            ]);

            $programme = Programme::create($validatedData);

            return response()->json([
                "message" => "Programme créé avec succès",
                "data"    => $programme
            ], 201);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Affiche un programme spécifique.
     */
    public function show(string $code_programme)
    {
        try {
            $programme = Programme::findOrFail($code_programme);
            return response()->json($programme, 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Programme non trouvé"], 404);
        }
    }

    /**
     * Met à jour un programme existant.
     */
    public function update(Request $request, string $code_programme)
    {
        try {
            $programme = Programme::findOrFail($code_programme);

            $validatedData = $request->validate([
                'code_ec'        => 'sometimes|string|min:5',
                'salle_id'        => 'sometimes|integer|exists:salle,id',
                'code_personnel' => 'sometimes|string|min:3',
                'date'           => 'sometimes|date',
                'heure_debut'    => 'sometimes|date_format:H:i',
                'heure_fin'      => 'sometimes|date_format:H:i',
                'nombre_dheure'  => 'sometimes|integer|min:1',
                'statut'         => 'sometimes|string'
            ]);

            $programme->update($validatedData);

            return response()->json([
                "message" => "Programme mis à jour avec succès",
                "data"    => $programme
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Supprime un programme selon son identifiant.
     */
    public function destroy(string $code_programme)
    {
        try {
            $programme = Programme::findOrFail($code_programme);
            $programme->delete();

            return response()->json([
                "message" => "Suppression réussie"
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Programme non trouvé"
            ], 404);
        }
    }
}
