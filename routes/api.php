<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::post('/create-user', [\App\Http\Controllers\Api\AuthController::class, 'createUser'])
        ->name('createUser');

    Route::post('/generate-token', [\App\Http\Controllers\Api\AuthController::class, 'generateToken'])
        ->name('generateToken');
});

Route::group(['prefix' => 'leagues', 'as' => 'leagues.', 'middleware' => 'api_auth'], function () {
    Route::get('/', [\App\Http\Controllers\Api\LeaguesController::class, 'leagues'])
        ->name('all');

    Route::get('/{leagueId}', [\App\Http\Controllers\Api\LeaguesController::class, 'leaguesById'])
        ->name('findById');
});
