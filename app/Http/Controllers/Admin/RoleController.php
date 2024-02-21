<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\LogActivity;
use App\Permission;
use App\Role;
use App\User;
use Auth;
use Illuminate\Http\Request;

class RoleController extends Controller
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

        // recupero i ruoli
        $roles = Role::sortable(['name' => 'asc'])->paginate(config('app.default_paginate'));

        return view('admin.roles.index', compact('roles'));
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

        // recupero i permessi
        $permissions = Permission::orderBy('name', 'asc')->get();

        return view('admin.roles.create', compact('permissions'));
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
            'name' => 'required|unique:roles,name|alpha|min:4|max:150',
            'permissions' => 'exists:permissions,id'
        ]);

        // creo un nuovo ruolo
        $newRole = new Role();
        $newRole->name = ucfirst($request->name);
        $newRole->save();

        // allego i permessi
        $newRole->permissions()->attach($request->permissions);

        // aggiungo il log attività
        LogActivity::addLog("Creato Ruolo: {$newRole->name}");

        return redirect()->route('admin.roles.index')->with('success', "Il Ruolo con nome {$newRole->name} è stato creato");
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

        // recupero il ruolo
        $role = Role::findOrFail($id);

        // recupero i dati per le relazioni
        $permissions = Permission::orderBy('name', 'asc')->get();

        return view('admin.roles.show', compact('role', 'permissions'));
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

        // recupero il ruolo
        $role = Role::findOrFail($id);

        // recupero i dati per le relazioni
        $permissions = Permission::orderBy('name', 'asc')->get();

        // controllo se il nome del ruolo è Admin
        if($role->name == 'Admin') {
            return redirect()->route('admin.roles.index')->with('error', "Non puoi modificare il Ruolo {$role->name}");
        }

        return view('admin.roles.edit', compact('role', 'permissions'));
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
            'name' => 'required|alpha|min:4|max:150|unique:roles,name,'.$id,
            'permissions' => 'exists:permissions,id'
        ]);

        // aggiorno il ruolo
        $role = Role::find($id);
        $role->name = ucfirst($request->name);
        $role->update();

        // aggiorno i permessi
        $role->permissions()->sync($request->permissions);

        // aggiungo il log attività
        LogActivity::addLog("Modificato Ruolo: {$role->name}");

        return redirect()->route('admin.roles.index')->with('success', "Il Ruolo {$role->name} è stato aggiornato");
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

        // recupero il ruolo
        $role = Role::findOrFail($id);

        // recupero l'utente by role id
        $user = User::whereRoleId($id)->first();

        // controllo se esiste almeno un utente con il ruolo passato
        if($user) {
            return redirect()->route('admin.roles.index')->with('error', "Non puoi eliminare il Ruolo {$role->name}, esistono degli utenti con questo Ruolo.");
        }

        if($role->name == 'Admin') {
            // aggiungo il log attività
            LogActivity::addLog("Ha provato ad eliminare il Ruolo: {$role->name}");

            return redirect()->route('admin.roles.index')->with('error', "Non puoi eliminare il Ruolo {$role->name} !");
        }

        // elimino il ruolo
        $role->delete();

        // aggiungo il log attività
        LogActivity::addLog("Eliminato Ruolo: {$role->name}");

        return redirect()->route('admin.roles.index')->with('success', "Il Ruolo con nome: {$role->name} è stato eliminato");
    }
}