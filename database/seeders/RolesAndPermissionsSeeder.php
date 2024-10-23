<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'create accounts']);
        Permission::create(['name' => 'view accounts']);
        Permission::create(['name' => 'edit accounts']);
        Permission::create(['name' => 'delete accounts']);

        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        $adminRole->givePermissionTo(['create accounts', 'view accounts', 'edit accounts', 'delete accounts']);
        $userRole->givePermissionTo(['create accounts', 'view accounts', 'edit accounts']);
    }
}