<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // permissions
        $allPermissionsId = Permission::pluck('id')->all();
        $permissionClientsView = Permission::where('name', 'clients-view')->first();

        // array roles
        $roles = array(
            [
                "name" => 'Admin',
                "permissions" => $allPermissionsId
            ],
            [
                "name" => 'Manager',
                "permissions" => $allPermissionsId
            ],
            [
                "name" => 'User',
                "permissions" => $permissionClientsView->id
            ]
        );

        // data e ora corrente
        $dateTime = new DateTime();

        foreach ($roles as $role) {
            // creo nuova istanza di Role
            $newRole = new Role();

            // setto i valori
            $newRole->name = $role['name'];
            $newRole->created_at = $dateTime->modify("+ 1 seconds");
            $newRole->updated_at = $newRole->created_at;

            // save
            $newRole->save();

            // attach permissions
            $newRole->permissions()->attach($role['permissions']);
        }
    }
}
