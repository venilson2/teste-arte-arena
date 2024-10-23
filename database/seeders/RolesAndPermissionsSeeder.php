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
        Permission::create(['name' => 'create accounts', 'guard_name' => 'api']);
        Permission::create(['name' => 'view accounts', 'guard_name' => 'api']);
        Permission::create(['name' => 'edit accounts', 'guard_name' => 'api']);
        Permission::create(['name' => 'delete accounts', 'guard_name' => 'api']);

        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'api']);
        $userRole = Role::create(['name' => 'user', 'guard_name' => 'api']);

        $adminRole->givePermissionTo(['create accounts', 'view accounts', 'edit accounts', 'delete accounts']);
        $userRole->givePermissionTo(['create accounts', 'view accounts', 'edit accounts']);
    }
}