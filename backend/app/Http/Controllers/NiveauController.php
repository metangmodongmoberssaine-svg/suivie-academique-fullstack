<?php

namespace App\Http\Controllers;

use App\Models\Niveau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NiveauController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $niveau =Niveau::all();
        return response()->json($niveau, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'code_niveau' => 'required|string|min:4|unique:niveaux,code_niveau',
                'label_niveau' => 'required|min:5|string',
                'description_niveau' => 'required|string',
                'code_filiere' => 'required|string|exists:filieres,code_filiere',
            ]);

            $res = Niveau::create($validatedData);

            return response()->json(
                ["message" => "Niveau crée avec succes", "data" => $res],
                201
            );
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(String $code_niveau)
    {
        try{
            $niveau = Niveau::findOrFail($code_niveau);
            return response()->json($niveau, 200);
        } catch (\Throwable $th) {
            return response()->json(["message" =>"Niveau non trouvée"], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $code_niveau)
{
    try {
        $niveau = Niveau::findOrFail($code_niveau);

        $validatedData = $request->validate([
            'label_niveau' => 'sometimes|string|min:5'
        ]);

        $niveau->update($validatedData);

        return response()->json([
            "message" => "Niveau mis à jour avec succès",
            "data"    => $niveau
        ], 200);

    } catch (\Throwable $th) {
        return response()->json(["message" => $th->getMessage()], 500);
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $code_niveau)
    {
        try {
            $niveau = Niveau::findOrFail($code_niveau);
            $niveau->delete();
            return response()->json(
                ["message"=> "Suppression réussie"],
                200
            );
        } catch (\Throwable $th) {
            return response()->json(["message" =>"Niveau non trouvée"], 404);
        }
    }
}
