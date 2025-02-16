<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class LecturerSeeder extends Seeder
{
    public function run()
    {
        $lecturerRole = Role::where('name', 'lecturer')->first();

        $lecturers = [
            [
                'name' => 'Samuel Ocen',
                'email' => 'samuel.ocen@mmu.ac.ug',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'John Doe',
                'email' => 'john.doe@mmu.ac.ug',
                'password' => bcrypt('password'),
            ],
            // Add more lecturers as needed
        ];

        foreach ($lecturers as $lecturer) {
            User::create([
                'name' => $lecturer['name'],
                'email' => $lecturer['email'],
                'password' => $lecturer['password'],
                'role_id' => $lecturerRole->id,
            ]);
        }
    }
}
