<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // array permessi
        $permissions = array(
            "categories-view",
            "categories-create",
            "categories-edit",
            "categories-delete",
            "clients-view",
            "clients-create",
            "clients-edit",
            "clients-delete",
            "accounts-view",
            "accounts-create",
            "accounts-edit",
            "accounts-delete",
        );

        foreach ($permissions as $permission) {
            // creo nuova istanza Permission
            $newPermission = new Permission();

            // setto i valori
            $newPermission->name = $permission;

            // save
            $newPermission->save();
        }
    }
}