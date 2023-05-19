<?php

use App\PersonalAccessApiToken;
use Illuminate\Database\Seeder;

class PersonalAccessTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // creo nuova istanza access token
        $newToken = new PersonalAccessApiToken();

        // setto i valori
        $newToken->token_name = 'Api_Token';
        $newToken->token_code = Hash::make(config('app.api_token'));
        $newToken->abilities = 'GET/POST';

        // save
        $newToken->save();
    }
}
