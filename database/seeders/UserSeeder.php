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
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        $admin = User::firstOrCreate([
            'email'     => 'admin@example.com'
        ], [
            'name'      => 'Admin',
            'password'  => bcrypt('password'),
        ]);
        $admin->assignRole($adminRole);

        $user = User::firstOrCreate([
            'email'     => 'user1@example.com'
        ], [
            'name'      => 'Regular User1',
            'password'  => bcrypt('password'),
        ]);
        $user->assignRole($userRole);

        
        $user = User::firstOrCreate([
            'email'     => 'user2@example.com'
        ], [
            'name'      => 'Regular User2',
            'password'  => bcrypt('password'),
        ]);
        $user->assignRole($userRole);
    }
}