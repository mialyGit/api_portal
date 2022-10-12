<?php

use App\Http\Controllers\Api\UtilisateurController;



Route::post('utilisateurs', [UtilisateurController::class, 'store']);
Route::get('utilisateurs', [UtilisateurController::class, 'index']);
Route::get('utilisateurs/{id}', [UtilisateurController::class, 'show']);
Route::put('utilisateurs/{personnel}', [UtilisateurController::class, 'update']);
Route::delete('utilisateurs/{personnel}', [UtilisateurController::class, 'destroy']);


