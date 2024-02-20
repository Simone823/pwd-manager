<?php

namespace App\Http\Controllers;

use App\LogActivity;
use App\Role;
use App\User;
use Auth;
use Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->isAdmin()) {
            abort(401);
        }

        // recupero gli utenti
        $users = User::sortable(['surname' => 'asc'])->paginate(config('app.default_paginate'));

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->isAdmin()) {
            abort(401);
        }

        // recupero i dati per le relazioni
        $roles = Role::where('name', '!=', 'Admin')->orderBy('name', 'asc')->get();

        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(401);
        }

        // validazione request
        $request->validate([
            'name' => 'required|string|alpha|min:4|max:150',
            'surname' => 'required|string|alpha|min:4|max:150',
            'username' => 'required|string|unique:users,username|min:4|max:150',
            'email' => 'required|email|string|unique:users,email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id'
        ]);

        // creo un nuovo utente
        $newUser = new User();
        $newUser->name = ucfirst($request->name);
        $newUser->surname = ucfirst($request->surname);
        $newUser->username = strtolower($request->username);
        $newUser->email = $request->email;
        $newUser->password = Hash::make($request->password);
        $newUser->role_id = $request->role_id;
        $newUser->save();

        // aggiungo il log attività
        LogActivity::addLog("Creato Utente: {$newUser->username}");

        return redirect()->route('users.index')->with('success', "L'Utente con username: {$newUser->username} è stato creato.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(401);
        }

        // recupero l'utente
        $user = User::findOrFail($id);

        // recupero i dati per le relazioni
        $roles = Role::orderBy('name', 'asc')->get();

        return view('users.show', compact('user', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(401);
        }

        // recupero l'utente
        $user = User::findOrFail($id);

        // recupero i dati per le relazioni
        $roles = Role::where('name', '!=', 'Admin')->orderBy('name', 'asc')->get();

        // controllo se l'utente è admin
        if($user->username == 'admin') {
            return redirect()->route('users.index')->with('error', "Non puoi modificare l'Utente con username {$user->username} .");
        }

        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(401);
        }

        // validazione request
        $request->validate([
            'name' => 'required|string|alpha|min:4|max:150',
            'surname' => 'required|string|alpha|min:4|max:150',
            'username' => 'required|string|unique:users,username,'.$id.'|min:4|max:150',
            'email' => 'required|email|string|unique:users,email,'.$id.'|max:255',
            'role_id' => 'required|exists:roles,id'
        ]);

        // aggiorno l'utente
        $user = User::findOrFail($id);
        $user->name = ucfirst($request->name);
        $user->surname = ucfirst($request->surname);
        $user->username = strtolower($request->username);
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->update();

        // aggiungo il log attività
        LogActivity::addLog("Modificato Utente: {$user->username}");

        return redirect()->route('users.index')->with('success', "L'Utente con username {$user->username} è stato modificato.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(401);
        }
        
        // recupero l'utente
        $user = User::findOrFail($id);

        // controllo se l'username è admin
        if($user->username == 'admin') {
            // aggiungo il log attività
            LogActivity::addLog("Ha provato ad eliminare l'Utente: {$user->username}");

            return redirect()->route('users.index')->with('error', "Non puoi eliminare l'utente {$user->username}");
        }

        // elimino l'utente
        $user->delete();

        // aggiungo il log attività
        LogActivity::addLog("Eliminato Utente: {$user->username}");

        return redirect()->route('users.index')->with('success', "L'Utente con username: {$user->username} è stato eliminato");
    }
}