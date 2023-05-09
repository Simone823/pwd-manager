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

        // controllo se esistono account in sessione
        if(!empty(Session::get('home-accounts-filtered'))) {
            $accounts = Session::get('home-accounts-filtered');
        }

        return view('home', compact('accounts', 'categories', 'clients'));
    }

    /**
     * RICERCA ACCOUNT
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

        // controllo se esitono il filtri
        if(!empty($request->account_name) && !empty($request->client_id) && !empty($request->category_id)) {
            $accounts = Account::where('name','LIKE', "%{$request->account_name}%")
                ->where('client_id', $request->client_id)
                ->where('category_id', $request->category_id)->paginate(8);
                
            // salvo in sessione i filtri
            Session::put([
                'home-account_name-filter' => $request->account_name,
                'home-client_id-filter' => $request->client_id,
                'home-category_id-filter' => $request->category_id,
                'home-accounts-filtered' => $accounts
            ]);

            return redirect()->route('home');

        } else if(!empty($request->account_name) && !empty($request->client_id)) {
            $accounts = Account::where('name','LIKE', "%{$request->account_name}%")
                ->where('client_id', $request->client_id)->paginate(8);
                
            // salvo in sessione i filtri
            Session::put([
                'home-account_name-filter' => $request->account_name,
                'home-client_id-filter' => $request->client_id,
                'home-category_id-filter' => '',
                'home-accounts-filtered' => $accounts
            ]);

            return redirect()->route('home');
            
        } else if(!empty($request->account_name) && !empty($request->category_id)) {
            $accounts = Account::where('name','LIKE', "%{$request->account_name}%")
                ->where('category_id', $request->category_id)->paginate(8);
                
            // salvo in sessione i filtri
            Session::put([
                'home-account_name-filter' => $request->account_name,
                'home-client_id-filter' => '',
                'home-category_id-filter' => $request->category_id,
                'home-accounts-filtered' => $accounts
            ]);

            return redirect()->route('home');
           
        } else if(!empty($request->client_id) && !empty($request->category_id)) {
            $accounts = Account::where('client_id', $request->client_id)
                ->where('category_id', $request->category_id)->paginate(8);

            // salvo in sessione i filtri
            Session::put([
                'home-account_name-filter' => '',
                'home-client_id-filter' => $request->client_id,
                'home-category_id-filter' => $request->category_id,
                'home-accounts-filtered' => $accounts
            ]);

            return redirect()->route('home');
            
        } else if(!empty($request->account_name)) {
            $accounts = Account::where('name','LIKE', "%{$request->account_name}%")->paginate(8);
                
            // salvo in sessione i filtri
            Session::put([
                'home-account_name-filter' => $request->account_name,
                'home-client_id-filter' => '',
                'home-category_id-filter' => '',
                'home-accounts-filtered' => $accounts
            ]);

            return redirect()->route('home');
            
        } else if(!empty($request->client_id)) {
            $accounts = Account::where('client_id', $request->client_id)->paginate(8);

            // salvo in sessione i filtri
            Session::put([
                'home-account_name-filter' => '',
                'home-client_id-filter' => $request->client_id,
                'home-category_id-filter' => '',
                'home-accounts-filtered' => $accounts
            ]);

            return redirect()->route('home');

        } else if(!empty($request->category_id)) {
            $accounts = Account::where('category_id', $request->category_id)->paginate(8);

            // salvo in sessione i filtri
            Session::put([
                'home-account_name-filter' => '',
                'home-client_id-filter' => '',
                'home-category_id-filter' => $request->category_id,
                'home-accounts-filtered' => $accounts
            ]);

            return redirect()->route('home');
        }

        // svuoto i filtri in sessione
        Session::forget([
            'home-account_name-filter',
            'home-category_id-filter',
            'home-client_id-filter',
            'home-accounts-filtered'
        ]);

        return redirect()->route('home')->with('error', "Inserire almeno un campo per la ricerca.");
    }
}
