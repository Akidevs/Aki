<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Owner']);
        Role::create(['name' => 'Renter']);

        // Create permissions
        Permission::create(['name' => 'manage products']);
        Permission::create(['name' => 'upload product']);
        Permission::create(['name' => 'rent product']);
    }
}
