<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use Illuminate\Http\Request;
use App\Exports\FilieresExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\FiliereCreated;

class FiliereController extends Controller
{
    /**
     *  Liste des filières
     */
    public function index()
    {
        $filieres = Filiere::with("niveaux")->get();
        Log::info('Liste des filières récupérée', ['count' => $filieres->count()]);
        return response()->json($filieres, 200);
    }

    /**
     * Créer une filière
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'code_filiere'  => 'required|min:5|string|unique:filieres,code_filiere',
                'label_filiere' => 'required|min:5|string',
                'description_filiere' => 'required|min:5|string'
            ]);

            $res = Filiere::create($validatedData);

            Log::info('Filiere créée avec succès', [
                'code' => $res->code_filiere,
                'label' => $res->label_filiere
            ]);

            // Envoyer un e-mail de notification en local (Mailpit)
            try {
                \Illuminate\Support\Facades\Mail::to(config('mail.from.address'))->send(new \App\Mail\FiliereCreated($res));
                Log::info('Mail de création envoyé', ['to' => config('mail.from.address'), 'code' => $res->code_filiere]);
            } catch (\Throwable $e) {
                Log::error('Echec envoi mail de création', ['exception' => $e->getMessage()]);
            }

            return response()->json(
                ["message" => "Filiere créée avec succès", "data" => $res],
                201
            );
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la création de filière', ['exception' => $th->getMessage()]);
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    /**
     *  Afficher une filière
     */
    public function show(string $code_filiere)
    {
        try {
            $filiere = Filiere::with("niveaux")->findOrFail($code_filiere);
            Log::info('Filiere affichée', ['code' => $code_filiere]);
            return response()->json($filiere, 200);
        } catch (\Throwable $th) {
            Log::warning('Filiere non trouvée', ['code' => $code_filiere]);
            return response()->json(["message" => "Filiere non trouvée"], 404);
        }
    }

    /**
     *  Modifier une filière
     */
    public function update(Request $request, string $code_filiere)
    {
        try {
            $filiere = Filiere::findOrFail($code_filiere);

            $validatedData = $request->validate([
                'label_filiere' => 'sometimes|string|min:5',
                'description_filiere' => 'sometimes|string|min:5',
            ]);

            $filiere->update($validatedData);

            Log::info('Filiere mise à jour', [
                'code' => $code_filiere,
                'changes' => $validatedData
            ]);

            return response()->json([
                "message" => "Filiere mise à jour avec succès",
                "data"    => $filiere
            ], 200);

        } catch (\Throwable $th) {
            Log::error('Erreur lors de la mise à jour', [
                'code' => $code_filiere,
                'exception' => $th->getMessage()
            ]);
            return response()->json(["message" => $th->getMessage()], 500);
        }
    }

    /**
     *  Supprimer une filière
     */
    public function destroy(string $code_filiere)
    {
        try {
            $filiere = Filiere::findOrFail($code_filiere);
            $filiere->delete();

            Log::info('Filiere supprimée', ['code' => $code_filiere]);

            return response()->json(
                ["message" => "Suppression réussie"],
                200
            );
        } catch (\Throwable $th) {
            Log::warning('Suppression échouée, filiere non trouvée', ['code' => $code_filiere]);
            return response()->json(["message" => "Filiere non trouvée"], 404);
        }
    }

    /**
     *  Exporter en Excel
     */
    public function exportExcel()
    {
        Log::info('Export Excel lancé');
        return Excel::download(new FilieresExport, 'filieres.xlsx');
    }

    /**
     *  Exporter en PDF
     */
    public function exportPdf()
    {
        try {
            $filieres = Filiere::all();
            $pdf = Pdf::loadView('exports.filiere', compact('filieres'));
            Log::info('Export PDF lancé', ['count' => $filieres->count()]);
            return $pdf->download('filieres.pdf');
        } catch (\Throwable $th) {
            Log::error('Export PDF échoué', ['exception' => $th->getMessage()]);
            return response()->json(['message' => 'Export PDF échoué. Voir logs.'], 500);
        }
    }
}
