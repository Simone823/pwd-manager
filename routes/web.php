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

    // Rotte categorie
    Route::get('/categories/index', 'CategoryController@index')->middleware('hasPermission:categories-view')->name('categories.index');
    Route::get('/categories/create', 'CategoryController@create')->middleware('hasPermission:categories-create')->name('categories.create');
    Route::post('/categories/store', 'CategoryController@store')->middleware('hasPermission:categories-create')->name('categories.store');
    Route::get('/categories/edit/{id}', 'CategoryController@edit')->middleware('hasPermission:categories-edit')->name('categories.edit');
    Route::put('/categories/update/{id}', 'CategoryController@update')->middleware('hasPermission:categories-edit')->name('categories.update');
    Route::delete('/categories/delete/{id}', 'CategoryController@destroy')->middleware('hasPermission:categories-delete')->name('categories.destroy');

    // Rotte clienti
    Route::get('/clients/index', 'ClientController@index')->middleware('hasPermission:clients-view')->name('clients.index');
    Route::get('/clients/create', 'ClientController@create')->middleware('hasPermission:clients-create')->name('clients.create');
    Route::post('/clients/store', 'ClientController@store')->middleware('hasPermission:clients-create')->name('clients.store');
    Route::get('/clients/edit/{id}', 'ClientController@edit')->middleware('hasPermission:clients-edit')->name('clients.edit');
    Route::put('/clients/update/{id}', 'ClientController@update')->middleware('hasPermission:clients-edit')->name('clients.update');
    Route::delete('/clients/delete/{id}', 'ClientController@destroy')->middleware('hasPermission:clients-delete')->name('clients.destroy');

    // Rotte middleware role admin
    Route::middleware('hasRole:admin')->group(function () {
        // Rotte permissions
        Route::resource('/permissions', 'PermissionController')->only(['index', 'destroy']);

        // Rotte roles
        Route::resource('/roles', 'RoleController');

        // Rotte users
        Route::resource('/users', 'UserController');
    });
});
