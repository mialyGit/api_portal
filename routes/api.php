<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GradeController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\FonctionController;
use App\Http\Controllers\Api\TypeUserController;
use App\Http\Controllers\Api\DirectionController;
use App\Http\Controllers\Api\PersonnelController;
use App\Http\Controllers\Api\PrivilegeController;
use App\Http\Controllers\Api\ApplicationController;
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
Route::post('personnels/register', [PersonnelController::class, 'register']);
Route::post('personnels/login', [PersonnelController::class, 'login']);

Route::get('personnels', [PersonnelController::class, 'index']);
Route::get('personnels/{id}', [PersonnelController::class, 'show']);
Route::put('personnels/{personnel}', [PersonnelController::class, 'update']);
Route::delete('personnels/{personnel}', [PersonnelController::class, 'destroy']);
Route::delete('personnels_all', [PersonnelController::class, 'destroy_all']);
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

Route::resource('user_privilege_apps', UserPrivilegeAppController::class);
Route::delete('user_privilege_apps_all', [UserPrivilegeAppController::class, 'destroy_all']);

Route::resource('type_users', TypeUserController::class);
Route::delete('type_users_all', [TypeUserController::class, 'destroy_all']);

/*Route::middleware('auth:sanctum')->group(function () {
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);
    Route::post('users/logout', [UserController::class, 'logout']);
});*/
