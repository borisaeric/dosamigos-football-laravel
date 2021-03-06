<?php

use Illuminate\Http\Request;

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

// Routes for Club model
Route::resource('club', 'ClubController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);

// Routes for Season model
Route::resource('season', 'SeasonController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);

// Nested routes for Season/Match model
Route::resource('season.match', 'MatchController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
