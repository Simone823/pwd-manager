<?php

use App\Client;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        // data e ora corrente
        $dateTime = new DateTime();

        // random fake client
        for ($i = 0; $i < 10; $i++) {
            // nuova istanza Client
            $newClient = new Client();

            // setto i valori
            $newClient->name = $faker->name();
            $newClient->created_at = $dateTime->modify("+ 1 seconds");
            $newClient->updated_at = $newClient->created_at;

            // save
            $newClient->save();
        }
    }
}
