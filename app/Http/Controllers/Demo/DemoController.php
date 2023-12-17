<?php

namespace App\Http\Controllers\Demo;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Artisan;
use Hash;
use Illuminate\Http\Request;

class DemoController extends Controller
{
    /**
     * Home Rotta default sito, mostra pulsante per preparare la demo
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // recupero l'utente demo
        $demoUser = User::whereUsername('demouser')->first();

        // controllo se esiste l'utente
        if(!empty($demoUser)) {
            return redirect()->route('login');
        }

        return view('demo.index');
    }

    /**
     * Prepara demo
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function prepareDemo(Request $request)
    {
        // chiamo il comando php artisan migrate --seed
        Artisan::call('migrate', ['--seed' => true]);

        // creo l'utente demo
        $demoUser = new User();

        // set value
        $demoUser->name = 'Demo';
        $demoUser->surname = 'User';
        $demoUser->username = 'demouser';
        $demoUser->email = 'demouser@pwdmanager.demo';
        $demoUser->password = Hash::make($demoUser->passwordDemoUser);
        $demoUser->role_id = Role::whereName('Admin')->pluck('id')->first();

        // save
        $demoUser->save();

        return redirect()->route('login')->with([
            'username' => $demoUser->username,
            'password' => $demoUser->passwordDemoUser
        ]);
    }

    /**
     * Resetta demo
     *
     * @return void
     */
    public function resetDemo()
    {
        Artisan::call('migrate:fresh');
    }
}
