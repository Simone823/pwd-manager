<?php

use App\Account;
use App\Category;
use App\Client;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        // categories
        $categoryEmailId = Category::where('name', 'Email')->pluck('id')->first();
        $categorySocialId = Category::where('name', 'Social')->pluck('id')->first();

        // client random
        $client = Client::all()->random()->first();

        // array accounts password
        $accounts = array(
            [
                'name' => 'Email Personale',
                'client_id' => $client->id,
                'category_id' => $categoryEmailId,
                'url' => $faker->url(),
                'username' => $faker->userName(),
                'password' => $faker->password(),
                'description' => ''
            ],
            [
                'name' => 'Email Website',
                'client_id' => $client->id,
                'category_id' => $categoryEmailId,
                'url' => $faker->url(),
                'username' => $faker->userName(),
                'password' => $faker->password(),
                'description' => ''
            ],
            [
                'name' => 'Email Agency',
                'client_id' => $client->id,
                'category_id' => $categoryEmailId,
                'url' => $faker->url(),
                'username' => $faker->userName(),
                'password' => $faker->password(),
                'description' => ''
            ],
            [
                'name' => 'Social Facebook',
                'client_id' => $client->id,
                'category_id' => $categorySocialId,
                'url' => $faker->url(),
                'username' => $faker->userName(),
                'password' => $faker->password(),
                'description' => ''
            ],
            [
                'name' => 'Social Twitter',
                'client_id' => $client->id,
                'category_id' => $categorySocialId,
                'url' => $faker->url(),
                'username' => $faker->userName(),
                'password' => $faker->password(),
                'description' => ''
            ],
            [
                'name' => 'Social Instagram',
                'client_id' => $client->id,
                'category_id' => $categorySocialId,
                'url' => $faker->url(),
                'username' => $faker->userName(),
                'password' => $faker->password(),
                'description' => ''
            ],
        );

        foreach ($accounts as $key => $account) {
            // creo nuova istanza Account
            $newAccount = new Account();

            // setto i valori
            $newAccount->name = $account['name'];
            $newAccount->client_id = $account['client_id'];
            $newAccount->category_id = $account['category_id'];
            $newAccount->url = $account['url'];
            $newAccount->username = $account['username'];
            $newAccount->password = Crypt::encryptString($account['password']);
            $newAccount->description = $account['description'];

            // save
            $newAccount->save();
        }
    }
}
