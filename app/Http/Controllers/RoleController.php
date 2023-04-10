<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
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
        $this->middleware('hasRole:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all roles orber by name asc
        $roles = Role::orderBy('name', 'asc')->paginate(10);

        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // recupero i permessi dal db ordinati per nome asc
        $permissions = Permission::orderBy('name', 'asc')->get();

        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validazione request
        $request->validate([
            'name' => 'required|unique:roles,name|alpha|min:4|max:150',
            'permissions' => 'exists:permissions,id'
        ]);

        // request data
        $data = $request->all();

        // creo un nuovo ruolo
        $newRole = new Role();

        // setto i valori
        $newRole->name = ucfirst($data['name']);

        // save
        $newRole->save();

        // controllo se esiste la key permessi
        if(array_key_exists('permissions', $data)) {
            $newRole->permissions()->attach($data['permissions']);
        } else {
            $newRole->permissions()->attach([]);
        }

        return redirect()->route('roles.index')->with('success', "Il Ruolo con nome {$newRole->name} è stato creato");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // recupero il ruolo by id
        $role = Role::find($id);

        // recupero tutti i permessi
        $permissions = Permission::orderBy('name', 'asc')->get();

        // controllo se il nome del ruolo è Admin
        if($role->name == 'Admin') {
            return redirect()->route('roles.index')->with('error', "Non puoi modificare il Ruolo {$role->name}");
        }

        return view('roles.edit', compact('role', 'permissions'));
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
        // validazione request
        $request->validate([
            'name' => 'required|alpha|min:4|max:150',
            'permissions' => 'exists:permissions,id'
        ]);

        // request data
        $data = $request->all();

        // recupero il ruolo by id
        $role = Role::find($id);

        // setto i valori
        $role->name = ucfirst($data['name']);

        // update
        $role->update();

        // controllo se esiste la key permessi
        if(array_key_exists('permissions', $data)) {
            $role->permissions()->sync($data['permissions']);
        } else {
            $role->permissions()->sync([]);
        }

        return redirect()->route('roles.index')->with('success', "Il Ruolo {$role->name} è stato aggiornato");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // recupero il ruolo by id
        $role = Role::find($id);

        if($role->name == 'Admin') {
            return redirect()->route('roles.index')->with('error', "Non puoi eliminare il Ruolo {$role->name} !");
        } else {
            $role->delete();
        }

        return redirect()->route('roles.index')->with('success', "Il Ruolo con nome: {$role->name} è stato eliminato");
    }
}
