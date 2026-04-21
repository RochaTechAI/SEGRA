<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AmostraController;

/*
|--------------------------------------------------------------------------
| API Routes - SEGRA Enterprise
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    // Rota completa para Amostras (Index, Store, Show, Update, Destroy)
    Route::apiResource('amostras', AmostraController::class);
});