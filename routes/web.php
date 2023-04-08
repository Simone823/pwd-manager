<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Rotte autenticazione
Auth::routes(["register" => false]);

// Rotte gruppo middleware auth
Route::middleware('auth')->group(function () {
    // Rotta default /
    Route::get('/', 'HomeController@index')->name('home');

    // Rotte middleware role admin
    Route::middleware('hasRole:admin')->group(function () {
        // Rotte permissions
        Route::resource('/permissions', 'PermissionController');
    });
});
