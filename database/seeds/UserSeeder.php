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
                'name' => 'admin',
                "username" => 'admin',
                'email' => 'admin@pwdmanager.test',
                'password' => 'PwdManager!!2023!!',
                "role_id" => $roleAdmin->id
            ],
            [
                'name' => 'manager',
                "username" => 'manager',
                'email' => 'manager@pwdmanager.test',
                'password' => 'PwdManager!!2023!!',
                "role_id" => $roleManager->id
            ],
            [
                'name' => 'simone',
                "username" => 'simone',
                'email' => 'simone@pwdmanager.test',
                'password' => 'PwdManager!!2023!!',
                "role_id" => $roleUser->id
            ]
        );

        // data e ora corrente
        $dateTime = new DateTime();

        foreach ($users as $key => $user) {
            // una istanza di User
            $newUser = new User();

            // setto i valori
            $newUser->name = ucfirst($user['name']);
            $newUser->username = strtolower($user['username']);
            $newUser->email = $user['email'];
            $newUser->password = Hash::make($user['password']);
            $newUser->role_id = $user['role_id'];
            $newUser->created_at = $dateTime->modify("+ 1 seconds");

            // save
            $newUser->save();
        }
    }
}
