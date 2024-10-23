<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'api']);
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'api']);

        $admin = User::firstOrCreate([
            'email'     => 'admin@example.com'
        ], [
            'name'      => 'Admin User',
            'password'  => bcrypt('password'),
            'role_id'   => $adminRole->id
        ]);
        $admin->assignRole($adminRole);

        $user = User::firstOrCreate([
            'email'     => 'user@example.com'
        ], [
            'name'      => 'Regular User',
            'password'  => bcrypt('password'),
            'role_id'   => $userRole->id
        ]);
        $user->assignRole($userRole);
    }
}