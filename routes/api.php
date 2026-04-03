<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AmostraController;

Route::prefix('v1')->group(function () {
    Route::get('/amostras', [AmostraController::class, 'index']);
    Route::get('/amostras/{amostra}', [AmostraController::class, 'show']);
    
    // Rota para criacao de novas amostras
    Route::post('/amostras', [AmostraController::class, 'store']);
});