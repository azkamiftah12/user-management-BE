<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        Role::create([
            'role_name' => 'admin',
        ]);
        Role::create([
            'role_name' => 'level_1',
        ]);
        User::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'password' => bcrypt('password'),
            'role_id' => 1,
        ]);
    }
}
