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
        // random fake client
        for ($i = 0; $i < 10; $i++) {
            // nuova istanza Client
            $newClient = new Client();

            // setto i valori
            $newClient->name = $faker->name();

            // save
            $newClient->save();
        }
    }
}
