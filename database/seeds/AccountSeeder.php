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
        $categoryEmailId = Category::where('category_name', 'Email')->pluck('id')->first();
        $categorySocialId = Category::where('category_name', 'Social')->pluck('id')->first();
        $categoryWebsiteId = Category::where('category_name', 'Website')->pluck('id')->first();
        $categoryDbMySqlId = Category::where('category_name', 'Database MySql')->pluck('id')->first();
        $categoryFtp = Category::where('category_name', 'FTP')->pluck('id')->first();

        // array accounts password
        $accounts = array(
            [
                'name' => 'Email Personale',
                'category_id' => $categoryEmailId,
                'url' => 'https://gmail.com',
                'username' => $faker->userName(),
                'password' => $faker->password(),
                'description' => ''
            ],
            [
                'name' => 'Email Website',
                'category_id' => $categoryEmailId,
                'url' => 'https://outlook.com',
                'username' => $faker->userName(),
                'password' => $faker->password(),
                'description' => ''
            ],
            [
                'name' => 'Email Agency',
                'category_id' => $categoryEmailId,
                'url' => 'https://gmail.com',
                'username' => $faker->userName(),
                'password' => $faker->password(),
                'description' => ''
            ],
            [
                'name' => 'Social Facebook',
                'category_id' => $categorySocialId,
                'url' => 'https://facebook.com',
                'username' => $faker->userName(),
                'password' => $faker->password(),
                'description' => ''
            ],
            [
                'name' => 'Social Twitter',
                'category_id' => $categorySocialId,
                'url' => 'https://twitter.com',
                'username' => $faker->userName(),
                'password' => $faker->password(),
                'description' => ''
            ],
            [
                'name' => 'Social Instagram',
                'category_id' => $categorySocialId,
                'url' => 'https://instagram.com',
                'username' => $faker->userName(),
                'password' => $faker->password(),
                'description' => ''
            ],
            [
                'name' => 'Website',
                'category_id' => $categoryWebsiteId,
                'url' => 'https://domain.com',
                'username' => $faker->userName(),
                'password' => $faker->password(),
                'description' => ''
            ],
            [
                'name' => 'Website wordpress',
                'category_id' => $categoryWebsiteId,
                'url' => 'https://examplewp.com',
                'username' => $faker->userName(),
                'password' => $faker->password(),
                'description' => ""
            ],
            [
                'name' => 'Website icons',
                'category_id' => $categoryWebsiteId,
                'url' => 'https://iconsweb.example',
                'username' => $faker->userName(),
                'password' => $faker->password(),
                'description' => ''
            ],
            [
                'name' => 'Website Personal',
                'category_id' => $categoryWebsiteId,
                'url' => 'https://personaldomain.com',
                'username' => $faker->userName(),
                'password' => $faker->password(),
                'description' => ''
            ],
            [
                'name' => 'Crm Aba Db MYSQL',
                'category_id' => $categoryDbMySqlId,
                'url' => $faker->localIpv4(),
                'username' => $faker->userName(),
                'password' => $faker->password(),
                'description' => "Nome Database: {$faker->userName()}"
            ],
            [
                'name' => 'Ftp domain.com',
                'category_id' => $categoryFtp,
                'url' => $faker->localIpv4(),
                'username' => $faker->userName(),
                'password' => $faker->password(),
                'description' => ""
            ],
            [
                'name' => 'Ftp domain.com',
                'category_id' => $categoryFtp,
                'url' => $faker->localIpv4(),
                'username' => $faker->userName(),
                'password' => $faker->password(),
                'description' => ""
            ],
            [
                'name' => 'Ftp personal website',
                'category_id' => $categoryFtp,
                'url' => $faker->localIpv4(),
                'username' => $faker->userName(),
                'password' => $faker->password(),
                'description' => ""
            ]
        );

        // date time current
        $dateTime = new DateTime();

        foreach ($accounts as $account) {
            // client random
            $clientRandom = Client::inRandomOrder()->first();

            // creo nuova istanza Account
            $newAccount = new Account();

            // setto i valori
            $newAccount->name = $account['name'];
            $newAccount->client_id = $clientRandom->id;
            $newAccount->category_id = $account['category_id'];
            $newAccount->url = $account['url'];
            $newAccount->username = $account['username'];
            $newAccount->password = Crypt::encryptString($account['password']);
            $newAccount->description = $account['description'];
            $newAccount->created_at = $dateTime->modify("+ 1 seconds");
            $newAccount->updated_at = $newAccount->created_at;

            // save
            $newAccount->save();
        }
    }
}
