<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Ec;

class EcController extends Controller
{
    /**
     * Afficher tous les EC
     */
    public function index()
    {
        return response()->json(Ec::all(), 200);
    }

    /**
     * Créer un nouvel EC avec upload PDF
     */
    public function store(Request $request)
    {
        $request->validate([
            'code_ec'        => 'required|string',
            'label_ec'       => 'nullable|string|min:3',
            'description_ec' => 'nullable|string|min:5',
            'nb_heures_ec'   => 'nullable|integer|min:1',
            'cours'          => 'nullable|string',
            'nb_credit_ec'   => 'nullable|integer|min:1',
            'code_ue'        => 'nullable|string|exists:ues,code_ue',
            'pdf_file'       => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $ec = new Ec();
        $ec->code_ec        = $request->code_ec;
        $ec->label_ec       = $request->label_ec;
        $ec->description_ec = $request->description_ec;
        $ec->nb_heures_ec   = $request->nb_heures_ec;
        $ec->cours          = $request->cours;
        $ec->nb_credit_ec   = $request->nb_credit_ec;
        $ec->code_ue        = $request->code_ue;

    if ($request->hasFile('pdf_file')) {
    $path = $request->file('pdf_file')->store('ec_pdfs', 'public');
    $ec->pdf_path = $path; // ✅ stocké en base
}

$ec->save();

// ✅ ajouter pdf_url uniquement pour la réponse
$ec->pdf_url = $ec->pdf_path ? asset('storage/' . $ec->pdf_path) : null;

return response()->json($ec, 201);


        $ec->save();

        return response()->json([
            "message" => "EC créé avec succès",
            "data"    => $ec
        ], 201);
    }

    /**
     * Mettre à jour un EC et son PDF
     */
    public function update(Request $request, string $code_ec)
    {
        try {
            $ec = Ec::findOrFail($code_ec);

            $validatedData = $request->validate([
                'label_ec'       => 'sometimes|string|min:3',
                'description_ec' => 'sometimes|string|min:5',
                'nb_heures_ec'   => 'sometimes|integer|min:1',
                'cours'          => 'sometimes|string',
                'nb_credit_ec'   => 'sometimes|integer|min:1',
                'code_ue'        => 'sometimes|string|exists:ues,code_ue',
                'pdf_file'       => 'sometimes|file|mimes:pdf|max:5120',
            ]);

            if ($request->hasFile('pdf_file')) {
                if ($ec->pdf_path && Storage::disk('public')->exists($ec->pdf_path)) {
                    Storage::disk('public')->delete($ec->pdf_path);
                }

                $path = $request->file('pdf_file')->store('ec_pdfs', 'public');
                $validatedData['pdf_path'] = $path;
            }

            $ec->update($validatedData);

            return response()->json([
                "message" => "EC mis à jour avec succès",
                "data"    => $ec
            ], 200);

        } catch (\Throwable $th) {
            return response()->json(["message" => $th->getMessage()], 500);
        }
    }

    /**
     * Supprimer un EC et son PDF associé
     */
    public function destroy(string $code_ec)
    {
        try {
            $ec = Ec::findOrFail($code_ec);

            if ($ec->pdf_path && Storage::disk('public')->exists($ec->pdf_path)) {
                Storage::disk('public')->delete($ec->pdf_path);
            }

            $ec->delete();

            return response()->json([
                "message" => "Suppression réussie"
            ], 200);

        } catch (\Throwable $th) {
            return response()->json(["message" => "EC non trouvé"], 404);
        }
    }
}
