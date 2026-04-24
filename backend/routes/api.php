<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FiliereController;
use App\Http\Controllers\NiveauController;
use App\Http\Controllers\UeController;
use App\Http\Controllers\ProgrammeController;
use App\Http\Controllers\EcController;
use App\Http\Controllers\SalleController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\EnseigneController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route protégée par Sanctum
Route::apiResource('personnels', PersonnelController::class);
Route::apiResource('niveaux', NiveauController::class);
Route::apiResource('salles', SalleController::class);
Route::apiResource('filieres', FiliereController::class);
Route::apiResource('ecs', EcController::class);
Route::get('/filieres/export/excel', [FiliereController::class, 'exportExcel']);
Route::get('/filieres/export/pdf', [FiliereController::class, 'exportPdf']);

Route::middleware("auth:sanctum")->group(function(){

Route::apiResource('ues', UeController::class);
Route::apiResource('programmes', ProgrammeController::class);

});

// Les routes pour Enseigne utilisent une clé composite (code_ec + code_personnel)
// Remplaçons la resource par des routes explicites pour accepter les deux segments
Route::middleware('auth:sanctum')->group(function () {
	Route::get('enseignes', [EnseigneController::class, 'index']);
	Route::post('enseignes', [EnseigneController::class, 'store']);
	Route::get('enseignes/{code_ec}/{code_personnel}', [EnseigneController::class, 'show']);
	Route::put('enseignes/{code_ec}/{code_personnel}', [EnseigneController::class, 'update']);
	Route::delete('enseignes/{code_ec}/{code_personnel}', [EnseigneController::class, 'destroy']);
});

Route::post("/login",[AuthController::class,"login"]);

