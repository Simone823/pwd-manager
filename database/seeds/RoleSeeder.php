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

        foreach ($roles as $key => $role) {
            // creo nuova istanza di Role
            $newRole = new Role();

            // setto i valori
            $newRole->name = $role['name'];

            // save
            $newRole->save();

            // attach permissions
            $newRole->permissions()->attach($role['permissions']);
        }
    }
}