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

// Rotte middleware check token api
Route::middleware('checkApiToken')->namespace('Api')->group(function() {

    // Rotta ottieni username & password dell'account
    Route::get('/viewPasswordAccount', 'AccountController@viewPasswordAccount');
});

// Route fallback not exist
Route::fallback(function () {
    return response()->json([
        'status' => 404,
        'message' => 'Page Not Found.'
    ], 404);
});