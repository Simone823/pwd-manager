<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Role;
use App\LogActivity;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // controllo se l'utente è diverso da quello loggato
        if($id != Auth::id()) {
            return abort(401);
        }

        // aggiungo il log attività
        LogActivity::addLog('Visualizza Profilo');

        // recupero l'utente e i ruoli
        $user = User::findOrFail($id);
        $roles = Role::orderBy('name', 'asc')->get();

        // log attività utente
        $userLogActivities = $user->logActivities()->sortable(['created_at' => 'desc'])->paginate(config('app.default_paginate'));

        return view('profiles.show', compact('user', 'roles', 'userLogActivities'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // controllo se l'utente è diverso da quello loggato
        if($id != Auth::id()) {
            return abort(401);
        }

        // aggiungo il log attività
        LogActivity::addLog('Modifica Profilo');

        // recupero l'utente
        $user = User::findOrFail($id);

        return view('profiles.edit', compact('user'));
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
        // controllo se l'utente è diverso da quello loggato
        if($id != Auth::id()) {
            return abort(401);
        }

        // validazione request
        $request->validate([
            'name' => 'required|string|alpha|min:4|max:150',
            'surname' => 'required|string|alpha|min:4|max:150',
            'email' => "required|email|string|unique:users,email,{$id}|max:255"
        ]);

        // recupero l'utente
        $user = User::findOrFail($id);

        if(!$user->isAdmin()) {
            $user->name = ucfirst($request->name);
            $user->surname = ucfirst($request->surname);
        }

        $user->email = $request->email;
        $user->update();

        // aggiungo il log attività
        LogActivity::addLog('Modificato Profilo');

        return redirect()->route('profiles.show', $user->id)->with('success', 'Il tuo profilo è stato modificato con successo');
    }

    /**
     * Cambia Password dell'utente loggato
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request, $id)
    {
        // controllo se l'utente è diverso da quello loggato
        if($id != Auth::id()) {
            return abort(401);
        }

        // validazione request
        $request->validate([
            'password' => 'required|string|min:8|confirmed'
        ]);

        // recupero l'utente
        $user = User::findOrFail($id);
        $user->password = Hash::make($request->password);
        $user->update();

        return redirect()->route('profiles.show', $user->id)->with('success', 'La nuova Password è stata salvata.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
