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


// Auth
Auth::routes(["register" => false]);

// Auth group
Route::middleware('auth')->group(function () {
    // Rotta default
    Route::get('/', 'HomeController@index')->name('home');

    // Admin
    Route::namespace('Admin')->name('admin.')->group(function () {
        // Permissions
        Route::get('/permissions/index', 'PermissionController@index')->name('permissions.index');

        // Roles
        Route::get('/roles/index', 'RoleController@index')->name('roles.index');
        Route::get('/roles/create', 'RoleController@create')->name('roles.create');
        Route::post('/roles/store', 'RoleController@store')->name('roles.store');
        Route::get('/roles/show/{id}', 'RoleController@show')->name('roles.show');
        Route::get('/roles/edit/{id}', 'RoleController@edit')->name('roles.edit');
        Route::post('/roles/update/{id}', 'RoleController@update')->name('roles.update');
        Route::delete('/roles/delete/{id}', 'RoleController@destroy')->name('roles.delete');

        // Users
        Route::get('/users/index', 'UserController@index')->name('users.index');
        Route::get('/users/create', 'UserController@create')->name('users.create');
        Route::post('/users/store', 'UserController@store')->name('users.store');
        Route::get('/users/show/{id}', 'UserController@show')->name('users.show');
        Route::get('/users/edit/{id}', 'UserController@edit')->name('users.edit');
        Route::post('/users/update/{id}', 'UserController@update')->name('users.update');
        Route::delete('/users/delete/{id}', 'UserController@destroy')->name('users.delete');

        // LogActivities
        Route::get('/log-activities/index', 'LogActivityController@index')->name('log-activities.index');
        Route::delete('/log-activities/delete/{id}', 'LogActivityController@destroy')->name('log-activities.delete');
        Route::post('/log-activities/deleteSelected', 'LogActivityController@deleteSelected')->name('log-activities.deleteSelected');
    });

    // Categories
    Route::get('/categories/index', 'CategoryController@index')->name('categories.index');
    Route::get('/categories/create', 'CategoryController@create')->name('categories.create');
    Route::post('/categories/store', 'CategoryController@store')->name('categories.store');
    Route::get('/categories/edit/{id}', 'CategoryController@edit')->name('categories.edit');
    Route::put('/categories/update/{id}', 'CategoryController@update')->name('categories.update');
    Route::delete('/categories/delete/{id}', 'CategoryController@destroy')->name('categories.destroy');
    Route::post('/categories/deleteSelected', 'CategoryController@deleteSelected')->name('categories.deleteSelected');

    // Clients
    Route::get('/clients/index', 'ClientController@index')->name('clients.index');
    Route::get('/clients/create', 'ClientController@create')->name('clients.create');
    Route::post('/clients/store', 'ClientController@store')->name('clients.store');
    Route::get('/clients/edit/{id}', 'ClientController@edit')->name('clients.edit');
    Route::put('/clients/update/{id}', 'ClientController@update')->name('clients.update');
    Route::delete('/clients/delete/{id}', 'ClientController@destroy')->name('clients.destroy');
    Route::post('/clients/deleteSelected', 'ClientController@deleteSelected')->name('clients.deleteSelected');

    // Accounts
    Route::get('/accounts/index', 'AccountController@index')->name('accounts.index');
    Route::get('/accounts/show/{id}', 'AccountController@show')->name('accounts.show');
    Route::get('/accounts/create', 'AccountController@create')->name('accounts.create');
    Route::post('/accounts/store', 'AccountController@store')->name('accounts.store');
    Route::get('/accounts/edit/{id}', 'AccountController@edit')->name('accounts.edit');
    Route::put('/accounts/update/{id}', 'AccountController@update')->name('accounts.update');
    Route::delete('/accounts/delete/{id}', 'AccountController@destroy')->name('accounts.destroy');
    Route::post('/accounts/deleteSelected', 'AccountController@deleteSelected')->name('accounts.deleteSelected');
    Route::post('/accounts/change-password/{id}', 'AccountController@changePassword')->name('accounts.changePassword');

    // Profile
    Route::get('/profiles/show/{id}', 'ProfileController@show')->name('profiles.show');
    Route::get('/profiles/edit/{id}', 'ProfileController@edit')->name('profiles.edit');
    Route::post('/profiles/update/{id}', 'ProfileController@update')->name('profiles.update');
    Route::post('/profiles/change-password/{id}', 'ProfileController@changePassword')->name('profiles.changePassword');
});