<?php

namespace App\Http\Controllers;

use App\Account;
use App\Category;
use App\Client;
use App\LogActivity;
use Auth;
use Illuminate\Http\Request;
use Session;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // aggiungo il log di attività
        LogActivity::addLog('Dashboard View');

        // controllo se l'utente può vedere gli accounts
        if (Auth::user()->hasPermission('accounts-view')) {
            // recupero i filtri account in sessione
            $filtersAccount = Session::get('filtersAccounts.home', []);

            if ($request->all()) {
                // request validate
                $request->validate([
                    'account_name' => 'nullable', 'max:230', 'regex:/^[a-zA-Z\s]+$/',
                    'client_id' => 'nullable', 'exists:clients,id',
                    'category_id' => 'nullable', 'exists:categories,id'
                ]);

                // aggiungo il log di attività
                LogActivity::addLog('Dashboard View Cerca Account');

                // salvo i filtri in sessione
                $filtersAccount = $request->all();
                Session::put('filtersAccounts.home', $filtersAccount);
            }

            // recupero gli account
            $queryAccount = Account::sortable(['created_at' => 'desc']);

            // applico i filtri se ci sono
            if (isset($filtersAccount['account_name']) && !empty($filtersAccount['account_name'])) {
                $queryAccount->where('name', 'LIKE', "%{$filtersAccount['account_name']}%");
            }

            if (isset($filtersAccount['client_id']) && !empty($filtersAccount['client_id'])) {
                $queryAccount->where('client_id', $filtersAccount['client_id']);
            }

            if (isset($filtersAccount['category_id']) && !empty($filtersAccount['category_id'])) {
                $queryAccount->where('category_id', $filtersAccount['category_id']);
            }

            // ottengo la query accounts
            $accounts = $queryAccount->paginate(config('app.default_paginate'));

            // recupero i dati relazioni account per i filtri
            $categories = Category::orderBy('category_name', 'asc')->get();
            $clients = Client::orderBy('name', 'asc')->get();
        }

        return view('home', compact('accounts', 'categories', 'clients'));
    }
}