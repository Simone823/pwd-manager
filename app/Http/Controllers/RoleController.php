<?php

namespace App\Http\Controllers;

use App\LogActivity;
use App\Permission;
use App\Role;
use App\User;
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
        // aggiungo il log attività
        LogActivity::addLog('Lista Ruoli');

        // get all roles orber by name asc
        $roles = Role::sortable(['name' => 'asc'])->paginate(10);

        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // aggiungo il log attività
        LogActivity::addLog('Creazione Ruolo');

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

        // aggiungo il log attività
        LogActivity::addLog("Creato Ruolo {$newRole->name}");

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
        // recupero il ruolo by id
        $role = Role::find($id);

        // recupero tutti i permessi 
        $permissions = Permission::orderBy('name', 'asc')->get();

        // aggiungo il log attività
        LogActivity::addLog("Visualizza Ruolo {$role->name}");

        return view('roles.show', compact('role', 'permissions'));
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
            // aggiungo il log attività
            LogActivity::addLog("Ha provato ad entrare in modifica Ruolo {$role->name}");

            return redirect()->route('roles.index')->with('error', "Non puoi modificare il Ruolo {$role->name}");
        }

        // aggiungo il log attività
        LogActivity::addLog("Modifica Ruolo {$role->name}");

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
            'name' => 'required|alpha|min:4|max:150|unique:roles,name,'.$id,
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

        // aggiungo il log attività
        LogActivity::addLog("Modificato Ruolo {$role->name}");

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

        // recupero l'utente by role id
        $user = User::whereRoleId($id)->first();

        // controllo se esiste almeno un utente con il ruolo passato
        if($user) {
            return redirect()->route('roles.index')->with('error', "Non puoi eliminare il Ruolo {$role->name}, esistono degli utenti con questo Ruolo.");
        }

        if($role->name == 'Admin') {
            // aggiungo il log attività
            LogActivity::addLog("Ha provato ad eliminare il Ruolo {$role->name}");

            return redirect()->route('roles.index')->with('error', "Non puoi eliminare il Ruolo {$role->name} !");
        } else {
            $role->delete();

            // aggiungo il log attività
            LogActivity::addLog("Eliminato Ruolo {$role->name}");
        }

        return redirect()->route('roles.index')->with('success', "Il Ruolo con nome: {$role->name} è stato eliminato");
    }
}
