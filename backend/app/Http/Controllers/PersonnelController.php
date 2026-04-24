<?php

namespace App\Http\Controllers;

use App\Models\Personnel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PersonnelController extends Controller
{
    /**
     * Afficher la liste des personnels
     */
    public function index()
    {
        $personnel = Personnel::all();
        return response()->json($personnel, 200);
    }

    /**
     * Créer un nouveau personnel
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'code_personnel'     => 'required|string|max:20|unique:personnel,code_personnel',
                'nom_personnel'      => 'required|string|min:5|max:191',
                'sex_personnel'      => 'required|in:M,F',
                'phone_personnel'    => 'required|digits_between:8,11',
                'login_personnel'    => 'required|string|max:191|unique:personnel,login_personnel',
                'password_personnel' => 'required|string|min:6',
                'type_personnel'     => 'required|in:ENSEIGNANT,RESPONSABLE_ACADEMIQUE,RESPONSABLE_FINANCIER'
            ]);

            //  Hachage du mot de passe
            $validatedData['password_personnel'] = Hash::make($validatedData['password_personnel']);

            $res = Personnel::create($validatedData);

            return response()->json([
                "message" => "Personnel créé avec succès",
                "data"    => $res
            ], 201);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Afficher un personnel spécifique
     */
    public function show(string $code_personnel)
    {
        try {
            $personnel = Personnel::findOrFail($code_personnel);
            return response()->json($personnel, 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Personnel non trouvé"], 404);
        }
    }

    /**
     * Mettre à jour un personnel
     */
    public function update(Request $request, string $code_personnel)
    {
        try {
            $personnel = Personnel::findOrFail($code_personnel);

            $validatedData = $request->validate([
                'nom_personnel'       => 'sometimes|string|min:5|max:191',
                'sex_personnel'       => 'sometimes|in:M,F',
                'phone_personnel'     => 'sometimes|digits_between:8,11',
                'login_personnel'     => 'sometimes|string|max:191|unique:personnel,login_personnel,' . $personnel->code_personnel . ',code_personnel',
                'password_personnel'  => 'sometimes|string|min:6',
                'type_personnel'      => 'sometimes|in:ENSEIGNANT,RESPONSABLE_ACADEMIQUE,RESPONSABLE_FINANCIER'
            ]);


            if (isset($validatedData['password_personnel'])) {
                $validatedData['password_personnel'] = Hash::make($validatedData['password_personnel']);
            }

            $personnel->update($validatedData);

            return response()->json([
                "message" => "Personnel mis à jour avec succès",
                "data"    => $personnel
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer un personnel
     */
    public function destroy(string $code_personnel)
    {
        try {
            $personnel = Personnel::findOrFail($code_personnel);
            $personnel->delete();

            return response()->json([
                "message" => "Suppression réussie"
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Personnel non trouvé"
            ], 404);
        }
    }
}
