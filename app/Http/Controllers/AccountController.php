<?php

namespace App\Http\Controllers;

use App\Account;
use App\Category;
use App\Client;
use App\LogActivity;
use Auth;
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
        if(!Auth::user()->hasPermission('accounts-view')) {
            abort(401);
        }

        // recupero gli accounts
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
        if(!Auth::user()->hasPermission('accounts-create')) {
            abort(401);
        }

        // recupero i dati per le relazioni
        $clients = Client::orderBy('name', 'asc')->get();
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
        if(!Auth::user()->hasPermission('accounts-create')) {
            abort(401);
        }

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

        // creo il nuovo account
        $newAccount = new Account();
        $newAccount->name = ucfirst($request->name);
        $newAccount->client_id = $request->client_id;
        $newAccount->category_id = $request->category_id;
        $newAccount->url = $request->url;
        $newAccount->username = $request->username;
        $newAccount->password = Crypt::encryptString($request->password);
        $newAccount->description = $request->description;
        $newAccount->save();

        // aggiungo il log attività
        LogActivity::addLog("Creato Account: {$newAccount->name}");

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
        if(!Auth::user()->hasPermission('accounts-view')) {
            abort(401);
        }

        // recupero l'account
        $account = Account::findOrFail($id);

        // recupero i dati per le relazioni
        $clients = Client::orderBy('name', 'asc')->get();
        $categories = Category::orderBy('category_name', 'asc')->get();

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
        if(!Auth::user()->hasPermission('accounts-edit')) {
            abort(401);
        }

        // recupero l'account
        $account = Account::findOrFail($id);
        
        // recupero i dati per le relazioni
        $clients = Client::orderBy('name', 'asc')->get();
        $categories = Category::orderBy('category_name', 'asc')->get();

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
        if(!Auth::user()->hasPermission('accounts-edit')) {
            abort(401);
        }

        // validazione request
        $request->validate([
            'name' => 'required|string|min:4|max:230',
            'client_id' => 'required|exists:clients,id',
            'category_id' => 'required|exists:categories,id',
            'url' => ['nullable', 'regex:/^(?:(?:https?|ftp):\/\/)?(?:[\w-]+\.)+[a-zA-Z]{2,}(?:\/\S*)?$|^(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})$/'],
            'username' => 'required|string|min:4|max:255',
            'description' => 'nullable|string'
        ]);

        // recupero l'account
        $account = Account::findOrFail($id);

        // setto i valori
        $account->name = ucfirst($request->name);
        $account->client_id = $request->client_id;
        $account->category_id = $request->category_id;
        $account->url = $request->url;
        $account->description = $request->description;

        // controllo se c'è la password nuova
        if(!empty($request->password)) {
            $account->password = Crypt::encryptString($request->password);
        }

        $account->update();

        // aggiungo il log attività
        LogActivity::addLog("Modificato Account: {$account->name}");

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
        if(!Auth::user()->hasPermission('accounts-delete')) {
            abort(401);
        }

        // elimino l'account
        $account = Account::findOrFail($id);
        $account->delete();

        // aggiungo il log attività
        LogActivity::addLog("Eliminato Account: {$account->name}");

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
        if(!Auth::user()->hasPermission('accounts-delete')) {
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
        $accounts = Account::whereIn('id', $request->idsRecord)->get();
        $accounts->each->delete();

        // Aggiungo il log attività
        foreach ($accounts as $account) {
            LogActivity::addLog("Eliminato Account: {$account->name}");
        }
        
        return response()->json([
            'status' => 200,
            'message' => 'Selected Accounts Password have been deleted.'
        ], 200);
    }

    /**
     * Cambia Password dell'account
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request, $id)
    {
        if(!Auth::user()->hasPermission('accounts-edit')) {
            abort(401);
        }

        // validazione request
        $request->validate([
            'password' => 'required|string|min:8|confirmed'
        ]);

        // recupero l'utente
        $account = Account::findOrFail($id);
        $account->password = Crypt::encryptString($request->password);
        $account->update();

        // aggiungo il log attività
        LogActivity::addLog("Cambio password dell'Account: {$account->name}");

        return redirect()->route('accounts.show', $account->id)->with('success', 'La nuova Password è stata salvata.');
    }
}