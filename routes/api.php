<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumniController;


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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/alumni', [AlumniController::class, 'index']);
Route::get('/alumni/{id}', [AlumniController::class, 'show']);
Route::post('/alumni', [AlumniController::class, 'store']);
Route::put('/alumni/{id}', [AlumniController::class, 'update']);
Route::delete('/alumni/{id}', [AlumniController::class, 'destroy']);
Route::get('/alumni/search/{name}', [AlumniController::class, 'searchByName']);
Route::get('/alumni/recent-graduates', [AlumniController::class, 'getRecentGraduates']);
Route::get('/alumni/employed', [AlumniController::class, 'getEmployed']);
Route::get('/alumni/unemployed', [AlumniController::class, 'getUnemployed']);

