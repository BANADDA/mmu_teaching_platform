<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $adminRole = Role::where('name', 'admin')->first();

        User::create([
            'name' => 'System Admin',
            'email' => 'admin@mmu.ac.ug',
            'password' => bcrypt('password'),
            'role_id' => $adminRole->id,
        ]);
    }
}
