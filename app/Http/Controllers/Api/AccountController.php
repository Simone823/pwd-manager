<?php

namespace App\Http\Controllers\Api;

use App\Account;
use App\Http\Controllers\Controller;
use Crypt;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * VISUALIZZA USERNAME & PASSWORD ACCOUNT
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

        // controllo se esiste l'account
        if(!$account) {
            return response()->json([
                'status' => 404,
                'message' => "Error. Account not found."
            ], 404);
        }

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
