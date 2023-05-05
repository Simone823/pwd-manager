<?php

namespace App\Http\Controllers;

use App\Account;
use App\Category;
use App\Client;
use App\LogActivity;
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
    public function index()
    {
        // aggiungo il log di attività
        LogActivity::addLog('Dashboard View');

        // recupero tutte le categorie dal db
        $categories = Category::orderBy('category_name', 'asc')->get();

        // recupero tutti i clienti dal db
        $clients = Client::orderBy('name', 'asc')->get();

        // recupero tutti gli accounts dal db
        $accounts = Account::sortable(['created_at' => 'desc'])->paginate(8);

        return view('home', compact('accounts', 'categories', 'clients'));
    }

    /**
     * CERCA ACCOUNT
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function searchAccounts(Request $request)
    {
        // aggiungo il log di attività
        LogActivity::addLog('Dashboard View Cerca Account');

        // request validate
        $request->validate([
            'account_name' => 'nullable', 'max:230', 'regex:/^[a-zA-Z\s]+$/',
            'client_id' => 'nullable', 'exists:clients,id',
            'category_id' => 'nullable', 'exists:categories,id'
        ]);
        
        // recupero tutte le categorie dal db
        $categories = Category::orderBy('category_name', 'asc')->get();

        // recupero tutti i clienti dal db
        $clients = Client::orderBy('name', 'asc')->get();

        if(!empty($request->account_name) && !empty($request->client_id) && !empty($request->category_id)) {
            $accounts = Account::where('name','LIKE', "%{$request->account_name}%")
                ->where('client_id', $request->client_id)
                ->where('category_id', $request->category_id)->paginate(8);
                
            if(count($accounts) > 0) {
                // salvo in sessione i filtri
                Session::put('home-account_name-filter', $request->account_name);
                Session::put('home-client_id-filter', $request->client_id);
                Session::put('home-category_id-filter', $request->category_id);

                return view('home', compact('accounts', 'categories', 'clients'));
            }
        } else if(!empty($request->account_name) && !empty($request->client_id)) {
            $accounts = Account::where('name','LIKE', "%{$request->account_name}%")
                ->where('client_id', $request->client_id)->paginate(8);
                
            if(count($accounts) > 0) {
                // salvo in sessione i filtri
                Session::put('home-account_name-filter', $request->account_name);
                Session::put('home-client_id-filter', $request->client_id);
                Session::put('home-category_id-filter', '');

                return view('home', compact('accounts', 'categories', 'clients'));
            }
        } else if(!empty($request->account_name) && !empty($request->category_id)) {
            $accounts = Account::where('name','LIKE', "%{$request->account_name}%")
                ->where('category_id', $request->category_id)->paginate(8);
                
            if(count($accounts) > 0) {
                // salvo in sessione i filtri
                Session::put('home-account_name-filter', $request->account_name);
                Session::put('home-client_id-filter', '');
                Session::put('home-category_id-filter', $request->category_id);

                return view('home', compact('accounts', 'categories', 'clients'));
            }
        } else if(!empty($request->client_id) && !empty($request->category_id)) {
            $accounts = Account::where('client_id', $request->client_id)
                ->where('category_id', $request->category_id)->paginate(8);

            if(count($accounts) > 0) {
                // salvo in sessione i filtri
                Session::put('home-account_name-filter', '');
                Session::put('home-client_id-filter', $request->client_id);
                Session::put('home-category_id-filter', $request->category_id);

                return view('home', compact('accounts', 'categories', 'clients'));
            }
        } else if(!empty($request->account_name)) {
            $accounts = Account::where('name','LIKE', "%{$request->account_name}%")->paginate(8);
                
            if(count($accounts) > 0) {
                // salvo in sessione i filtri
                Session::put('home-account_name-filter', $request->account_name);
                Session::put('home-client_id-filter', '');
                Session::put('home-category_id-filter', '');

                return view('home', compact('accounts', 'categories', 'clients'));
            }
        } else if(!empty($request->client_id)) {
            $accounts = Account::where('client_id', $request->client_id)->paginate(8);

            if(count($accounts) > 0) {
                // salvo in sessione i filtri
                Session::put('home-account_name-filter', '');
                Session::put('home-client_id-filter', $request->client_id);
                Session::put('home-category_id-filter', '');

                return view('home', compact('accounts', 'categories', 'clients'));
            }
        } else if(!empty($request->category_id)) {
            $accounts = Account::where('category_id', $request->category_id)->paginate(8);

            if(count($accounts) > 0) {
                // salvo in sessione i filtri
                Session::put('home-account_name-filter', '');
                Session::put('home-client_id-filter', '');
                Session::put('home-category_id-filter', $request->category_id);

                return view('home', compact('accounts', 'categories', 'clients'));
            }
        }

        // svuoto i filtri in sessione
        Session::forget([
            'home-account_name-filter',
            'home-category_id-filter',
            'home-client_id-filter'
        ]);

        return redirect()->route('home')->with('error', "Nessun risultato per questa ricerca");
    }
}
