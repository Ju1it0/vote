<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\PasswordController;
use App\Http\Controllers\Api\VoteController;
use App\Http\Controllers\Api\VoterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

// Rutas públicas
Route::post('/login', [AuthController::class, 'login']);
Route::get('/candidates', [VoterController::class, 'candidates']);
Route::get('/candidates/top', [VoterController::class, 'topCandidates']);
Route::post('/votes', [VoteController::class, 'store']);

// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {
    // Autenticación
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::put('/password', [PasswordController::class, 'update']);

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Rutas de votantes
    Route::apiResource('voters', VoterController::class);

    // Rutas de votos
    Route::get('/votes/most-voted', [VoteController::class, 'getMostVotedCandidate']);
    Route::get('/votes', [VoteController::class, 'index']);
    Route::get('/votes/{vote}', [VoteController::class, 'show']);
});
