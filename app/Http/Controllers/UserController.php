<?php

namespace App\Http\Controllers;

use App\LogActivity;
use App\Role;
use App\User;
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
        LogActivity::addLog('Lista Utenti');

        // recupero tutti gli utenti dal db ordinati per none
        $users = User::orderBy('name', 'asc')->paginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // aggiungo il log attività
        LogActivity::addLog('Creazione Utente');

        // recupero i ruoli tranne l'admin
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
        // validazione request
        $request->validate([
            'name' => 'required|string|alpha|min:4|max:150',
            'username' => 'required|string|unique:users,username|min:4|max:150',
            'email' => 'required|email|string|unique:users,email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id'
        ]);

        // request all data
        $data = $request->all();

        // creo un nuovo utente
        $newUser = new User();

        // setto i valori
        $newUser->name = ucfirst($data['name']);
        $newUser->username = strtolower($data['username']);
        $newUser->email = $data['email'];
        $newUser->password = Hash::make($data['password']);
        
        // controllo se esiste il ruolo
        if(array_key_exists('role_id', $data)) {
            $newUser->role_id = $data['role_id'];
        }

        // save
        $newUser->save();

        // aggiungo il log attività
        LogActivity::addLog("Creato Utente {$newUser->username}");

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
        // recupero l'utente by id
        $user = User::find($id);

        // recupero i ruoli tranne l'admin
        $roles = Role::where('name', '!=', 'Admin')->orderBy('name', 'asc')->get();

        // controllo se l'utente è admin
        if($user->username == 'admin') {
            // aggiungo il log attività
            LogActivity::addLog("Ha provato ad entrare in modifica Utente {$user->username}");

            return redirect()->route('users.index')->with('error', "Non puoi modificare l'Utente con username {$user->username} .");
        }

        // aggiungo il log attività
        LogActivity::addLog("Modifica Utente {$user->username}");

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
        // recupero l'utente by id
        $user = User::find($id);

        // validazione request
        $request->validate([
            'name' => 'required|string|alpha|min:4|max:150',
            'username' => 'required|string|unique:users,username,'.$id.'|min:4|max:150',
            'email' => 'required|email|string|unique:users,email,'.$id.'|max:255',
            'role_id' => 'required|exists:roles,id'
        ]);

        // data request all
        $data = $request->all();

        // aggiorno i valori utente
        $user->name = ucfirst($data['name']);
        $user->username = strtolower($data['username']);
        $user->email = $data['email'];

        // controllo se esiste il ruolo
        if(array_key_exists('role_id', $data)) {
            $user->role_id = $data['role_id'];
        }

        // update
        $user->update();

        // aggiungo il log attività
        LogActivity::addLog("Modificato Utente {$user->username}");

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
        // recupero l'utenti by id
        $user = User::find($id);

        // controllo se l'username è admin
        if($user->username == 'admin') {
            // aggiungo il log attività
            LogActivity::addLog("Ha provato ad eliminare l'Utente {$user->username}");

            return redirect()->route('users.index')->with('error', "Non puoi eliminare l'utente {$user->username}");
        } else {
            $user->delete();

            // aggiungo il log attività
            LogActivity::addLog("Eliminato Utente {$user->username}");
        }

        return redirect()->route('users.index')->with('success', "L'Utente con username: {$user->username} è stato eliminato");
    }
}