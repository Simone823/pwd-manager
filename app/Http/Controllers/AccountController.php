<?php

namespace App\Http\Controllers;

use App\Account;
use App\Category;
use App\Client;
use App\LogActivity;
use Crypt;
use Illuminate\Http\Request;

class AccountController extends Controller
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
        // aggiungo il log attività
        LogActivity::addLog("Lista Account");

        // recupero tuti gli account dal db
        $accounts = Account::sortable(['created_at' => 'desc'])->paginate(config('app.default_paginate'));

        return view('accounts.index', compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // aggiungo il log attività
        LogActivity::addLog("Creazione Account");

        // recupero tutti i clienti dal db
        $clients = Client::orderBy('name', 'asc')->get();

        // recupero tutte le categorie dal db
        $categories = Category::orderBy('category_name', 'asc')->get();

        return view('accounts.create', compact('clients', 'categories'));
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
            'name' => 'required|string|min:4|max:230',
            'client_id' => 'required|exists:clients,id',
            'category_id' => 'required|exists:categories,id',
            'url' => ['nullable', 'regex:/^(?:(?:https?|ftp):\/\/)?(?:[\w-]+\.)+[a-zA-Z]{2,}(?:\/\S*)?$|^(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})$/'],
            'username' => 'required|string|min:4|max:255',
            'password' => 'required|string|min:8|confirmed',
            'description' => 'nullable|string'
        ]);

        // data reuqest all
        $data = $request->all();

        // creo nuova istanza Account
        $newAccount = new Account();

        // setto i valori
        $newAccount->name = ucfirst($data['name']);
        $newAccount->client_id = $data['client_id'];
        $newAccount->category_id = $data['category_id'];
        $newAccount->url = $data['url'];
        $newAccount->username = $data['username'];
        $newAccount->password = Crypt::encryptString($data['password']);
        $newAccount->description = $data['description'];

        // save
        $newAccount->save();

        // aggiungo il log attività
        LogActivity::addLog("Creato Account {$newAccount->name}");

        return redirect()->route('accounts.show', $newAccount->id)->with('success', "L'Account con nome: {$newAccount->name} è stato creato.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // recupero l'account by id
        $account = Account::find($id);

        // recupero tutti i clienti dal db
        $clients = Client::orderBy('name', 'asc')->get();

        // recupero tutte le categorie dal db
        $categories = Category::orderBy('category_name', 'asc')->get();

        // aggiungo il log attività
        LogActivity::addLog("Visualizza Account {$account->name}");

        return view('accounts.show', compact('account', 'clients', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // recupero l'account by id
        $account = Account::find($id);
        
        // recupero tutti i clienti dal db
        $clients = Client::orderBy('name', 'asc')->get();
        
        // recupero tutte le categorie dal db
        $categories = Category::orderBy('category_name', 'asc')->get();

        // aggiungo il log attività
        LogActivity::addLog("Modifica Account {$account->name}");

        return view('accounts.edit', compact('account', 'clients', 'categories'));
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
        // recupero l'account by id
        $account = Account::find($id);

        // validazione request
        $request->validate([
            'name' => 'required|string|min:4|max:230',
            'client_id' => 'required|exists:clients,id',
            'category_id' => 'required|exists:categories,id',
            'url' => ['nullable', 'regex:/^(?:(?:https?|ftp):\/\/)?(?:[\w-]+\.)+[a-zA-Z]{2,}(?:\/\S*)?$|^(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})$/'],
            'username' => 'required|string|min:4|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'description' => 'nullable|string'
        ]);

        // data request all
        $data = $request->all();

        // setto i valori
        $account->name = ucfirst($data['name']);
        $account->client_id = $data['client_id'];
        $account->category_id = $data['category_id'];
        $account->url = $data['url'];
        $account->description = $data['description'];

        // controllo se c'è la password nuova
        if(array_key_exists('password', $data) && !empty($data['password'])) {
            $account->password = Crypt::encryptString($data['password']);
        } else {
            $account->password = $account->password;
        }

        // update account
        $account->update();

        // aggiungo il log attività
        LogActivity::addLog("Modificato Account {$account->name}");

        return redirect()->route('accounts.show', $account->id)->with('success', "L'Account con nome: {$account->name} è stato modificato.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // recupero l'account by id
        $account = Account::find($id);

        // delete
        $account->delete();

        // aggiungo il log attività
        LogActivity::addLog("Eliminato Account {$account->name}");

        return redirect()->back()->with('success', "L'Account con nome: {$account->name} è stato eliminato.");
    }

    /**
     * Elimina record selezionati
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function deleteSelected(Request $request)
    {
        // controllo se esiste almeno un id
        if(count($request->idsRecord) == 0) {
            return response()->json([
                'status' => 400,
                'message' => 'There are no selected record ids'
            ], 400);
        }

        
        // elimino tutt i record aventi gli id della request
        $accounts = Account::whereIn('id', $request->idsRecord)->delete();
        
        // Aggiungo il log attività
        LogActivity::addLog("Eliminati Account selezionati");
        
        return response()->json([
            'status' => 200,
            'message' => 'Selected Accounts Password have been deleted.'
        ], 200);
    }
}
