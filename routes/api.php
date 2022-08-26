<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TypeUserController;
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
Route::post('users/register', [UserController::class, 'register']);
Route::post('users/login', [UserController::class, 'login']);

Route::get('users', [UserController::class, 'index']);
Route::get('users/{user}', [UserController::class, 'show']);
Route::put('users/{user}', [UserController::class, 'update']);
Route::delete('users/{user}', [UserController::class, 'destroy']);
Route::delete('users_all', [UserController::class, 'destroy_all']);
// Route::post('upload', [UserController::class, 'upload_img_url']);

Route::resource('applications', ApplicationController::class);
Route::delete('applications_all', [ApplicationController::class, 'destroy_all']);

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
