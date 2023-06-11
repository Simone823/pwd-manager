<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // roles
        $roleAdmin = Role::where('name', '=', 'Admin')->first();
        $roleManager = Role::where('name', '=', 'Manager')->first();
        $roleUser = Role::where('name', '=', 'User')->first();

        // users array
        $users = array(
            [
                'name' => 'system',
                'surname' => 'administrator',
                "username" => 'admin',
                'email' => 'admin@pwdmanager.test',
                'password' => '!!PwdManager!.#23.,""',
                "role_id" => $roleAdmin->id
            ],
            [
                'name' => 'enair',
                'surname' => 'gibson',
                "username" => 'manager',
                'email' => 'gibson@pwdmanager.test',
                'password' => '!!PwdManager!.#23.,""',
                "role_id" => $roleManager->id
            ],
            [
                'name' => 'delta',
                'surname' => 'agenes',
                "username" => 'delta',
                'email' => 'agenes@pwdmanager.test',
                'password' => '!!PwdManager!.#23.,""',
                "role_id" => $roleUser->id
            ]
        );

        // data e ora corrente
        $dateTime = new DateTime();

        foreach ($users as $user) {
            // una istanza di User
            $newUser = new User();

            // setto i valori
            $newUser->name = ucfirst($user['name']);
            $newUser->surname = ucfirst($user['surname']);
            $newUser->username = strtolower($user['username']);
            $newUser->email = $user['email'];
            $newUser->password = Hash::make($user['password']);
            $newUser->role_id = $user['role_id'];
            $newUser->created_at = $dateTime->modify("+ 1 seconds");
            $newUser->updated_at = $newUser->created_at;

            // save
            $newUser->save();
        }
    }
}
