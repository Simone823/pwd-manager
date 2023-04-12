<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // recupero tutti i clienti da db
        $clients = Client::orderBy('name', 'asc')->paginate(10);

        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        // validazione request
        $request->validate([
            'name' => 'required|string|min:4|max:200|unique:clients,name',
            'description' => 'string|nullable'
        ]);

        // data request all
        $data = $request->all();

        // creo nuova istanza Client
        $newClient = new Client();

        // setto i valori
        $newClient->name = ucfirst($data['name']);
        $newClient->description = $data['description'];

        // save
        $newClient->save();

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
        // recupero il cliente by id
        $client = Client::find($id);

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
        // recupero il cliente by id
        $client = Client::find($id);

        // validazione request
        $request->validate([
            'name' => 'required|string|min:4|max:200|unique:clients,name,'.$id,
            'description' => 'string|nullable'
        ]);

        // data request all
        $data = $request->all();

        // update valori
        $client->name = ucfirst($data['name']);
        $client->description = $data['description'];

        // save
        $client->update();

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
        // recupero il cliente by id
        $client = Client::find($id);

        // delete
        $client->delete();

        return redirect()->route('clients.index')->with('success', "Il Cliente con nome: {$client->name} è stato eliminato.");
    }
}
