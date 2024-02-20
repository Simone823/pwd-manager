<?php

namespace App\Http\Controllers;

use App\Client;
use App\LogActivity;
use Auth;
use Illuminate\Http\Request;

class ClientController extends Controller
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
        if(!Auth::user()->hasPermission('clients-view')) {
            abort(401);
        }

        // recupero i clienti
        $clients = Client::sortable(['name' => 'asc'])->paginate(config('app.default_paginate'));

        // aggiungo il log attività
        LogActivity::addLog("Lista Clienti");

        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->hasPermission('clients-create')) {
            abort(401);
        }

        // aggiungo il log attività
        LogActivity::addLog("Creazione Cliente");

        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->hasPermission('clients-create')) {
            abort(401);
        }

        // validazione request
        $request->validate([
            'name' => 'required|string|min:4|max:200|unique:clients,name',
            'description' => 'string|nullable'
        ]);

        // creo il nuovo cliente
        $newClient = new Client();
        $newClient->name = ucfirst($request->name);
        $newClient->description = $request->description;
        $newClient->save();

        // aggiungo il log attività
        LogActivity::addLog("Creato Cliente {$newClient->name}");

        return redirect()->route('clients.index')->with('success', "Il Cliente con nome: {$newClient->name} è stato creato.");
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
        if(!Auth::user()->hasPermission('clients-edit')) {
            abort(401);
        }

        // recupero il cliente
        $client = Client::findOrFail($id);

        // aggiungo il log attività
        LogActivity::addLog("Modifica Cliente {$client->name}");

        return view('clients.edit', compact('client'));
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
        if(!Auth::user()->hasPermission('clients-edit')) {
            abort(401);
        }

        // validazione request
        $request->validate([
            'name' => 'required|string|min:4|max:200|unique:clients,name,'.$id,
            'description' => 'string|nullable'
        ]);

        // aggiorno il cliente
        $client = Client::findOrFail($id);
        $client->name = ucfirst($request->name);
        $client->description = $request->description;
        $client->update();

        // aggiungo il log attività
        LogActivity::addLog("Modificato Cliente {$client->name}");

        return redirect()->route('clients.index')->with('success', "Il Cliente con nome: {$client->name} è stato modificato.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Auth::user()->hasPermission('clients-delete')) {
            abort(401);
        }

        // elimino il cliente
        $client = Client::findOrFail($id);
        $client->delete();

        // aggiungo il log attività
        LogActivity::addLog("Eliminato Cliente {$client->name}");

        return redirect()->route('clients.index')->with('success', "Il Cliente con nome: {$client->name} è stato eliminato.");
    }

    /**
     * Elimina record selezionati
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function deleteSelected(Request $request)
    {
        if(!Auth::user()->hasPermission('clients-delete')) {
            abort(401);
        }

        // controllo se esiste almeno un id
        if(count($request->idsRecord) == 0) {
            return response()->json([
                'status' => 400,
                'message' => 'There are no selected record ids'
            ], 400);
        }
        
        // elimino tutt i record aventi gli id della request
        $clients = Client::whereIn('id', $request->idsRecord)->delete();
        
        // Aggiungo il log attività
        LogActivity::addLog("Eliminati Clienti selezionati");
        
        return response()->json([
            'status' => 200,
            'message' => 'Selected Clients have been deleted.'
        ], 200);
    }
}