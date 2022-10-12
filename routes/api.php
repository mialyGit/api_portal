<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GradeController;
use App\Http\Controllers\Api\DemandeController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\FonctionController;
use App\Http\Controllers\Api\TypeUserController;
use App\Http\Controllers\Api\DirectionController;
use App\Http\Controllers\Api\PersonnelController;
use App\Http\Controllers\Api\PrivilegeController;
use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\ContribuableController;
use App\Http\Controllers\Api\UserPrivilegeAppController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('users', [UserController::class, 'index']);
Route::post('users/login', [UserController::class, 'login']);
Route::get('users/validate/{user}', [UserController::class, 'validate_status']);
Route::get('users/unvalidate/{user}', [UserController::class, 'unvalidate_status']);

Route::get('users/demandes', [DemandeController::class, 'index']);
Route::post('users/activate/pers', [DemandeController::class, 'demande_pers']);
Route::post('users/activate/cont', [DemandeController::class, 'demande_cont']);
Route::post('users/logout', [UserController::class, 'logout']);
Route::delete('demandes_all', [DemandeController::class, 'destroy_all']);

Route::post('personnels', [PersonnelController::class, 'store']);
Route::get('personnels', [PersonnelController::class, 'index']);
Route::get('personnels/{id}', [PersonnelController::class, 'show']);
Route::put('personnels/{personnel}', [PersonnelController::class, 'update']);
Route::delete('personnels/{personnel}', [PersonnelController::class, 'destroy']);
Route::delete('personnels_all', [PersonnelController::class, 'destroy_all']);


Route::get('friends/{id}', [UserController::class, 'show_except']);
// Route::post('upload', [UserController::class, 'upload_img_url']);

Route::resource('directions', DirectionController::class);
Route::delete('directions_all', [DirectionController::class, 'destroy_all']);

Route::resource('services', ServiceController::class);
Route::get('search/services/{text}', [ServiceController::class, 'search']);
Route::delete('services_all', [ServiceController::class, 'destroy_all']);

Route::resource('applications', ApplicationController::class);
Route::delete('applications_all', [ApplicationController::class, 'destroy_all']);

Route::resource('fonctions', FonctionController::class);
Route::delete('fonctions_all', [FonctionController::class, 'destroy_all']);

Route::resource('grades', GradeController::class);
Route::delete('grades_all', [GradeController::class, 'destroy_all']);
// Route::resource('personnels', PersonnelController::class);
// Route::delete('personnels_all', [PersonnelController::class, 'destroy_all']);

Route::resource('privileges', PrivilegeController::class);
Route::delete('privileges_all', [PrivilegeController::class, 'destroy_all']);

Route::resource('contribuables', ContribuableController::class);
Route::delete('contribuables_all', [ContribuableController::class, 'destroy_all']);

Route::resource('demandes', DemandeController::class);
Route::delete('demandes_all', [DemandeController::class, 'destroy_all']);

Route::resource('user_privilege_apps', UserPrivilegeAppController::class);
Route::delete('user_privilege_apps_all', [UserPrivilegeAppController::class, 'destroy_all']);

Route::get('messages', [MessageController::class, 'index']);
Route::post('messages', [MessageController::class, 'store']);
Route::get('messages/{message}', [MessageController::class, 'show']);
Route::delete('messages/{message}', [MessageController::class, 'destroy']);
Route::delete('messages_all', [MessageController::class, 'destroy_all']);
Route::get('messages/{sender_id}/{rec_id}', [MessageController::class, 'conversations']);

// Route::resource('type_users', TypeUserController::class);
// Route::delete('type_users_all', [TypeUserController::class, 'destroy_all']);

/*Route::middleware('auth:sanctum')->group(function () {
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);
    Route::post('users/logout', [UserController::class, 'logout']);
});*/
