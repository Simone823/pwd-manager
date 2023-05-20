<?php

namespace App\Http\Controllers\Api;

use App\Account;
use App\Http\Controllers\Controller;
use App\LogActivity;
use Crypt;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * DECRYPT PASSWORD ACCOUNT
     *
     * @param Request $request
     * @return object
     */
    public function decryptPasswordAccount(Request $request): object
    {
        // controllo se esiste il parametro password
        if(!$request->has('password')) {
            return response()->json([
                'status' => 422,
                'message' => 'Param password is required.'
            ], 422);
        }

        // decrypt password
        try {
            $password = Crypt::decryptString($request->password);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 422,
                'message' => 'Error, Unable to decrypt password.'
            ], 422);
        }

        return response()->json([
            'status' => 200,
            'data' => [
                'password' => $password
            ]
        ], 200);
    }

    /**
     * VISUALIZZA PASSWORD ACCOUNT
     *
     * @param Request $request
     * @return object
     */
    public function viewPasswordAccount(Request $request): object
    {
        // controllo se esiste il parametro idAccount
        if(!$request->has('idAccount')) {
            return response()->json([
                'status' => 422,
                'message' => 'Param idAccount is required.'
            ], 422);
        }

        // recupero l'account by id
        $account = Account::find($request->idAccount);

        // decrypt password
        try {
            $account->password = Crypt::decryptString($account->password);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 422,
                'message' => 'Error, Unable to decrypt password.'
            ], 422);
        }

        return response()->json([
            'status' => 200,
            'data' => [
                'username' => $account->username,
                'password' => $account->password
            ]
        ], 200);
    }
}
