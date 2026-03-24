<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@yopmail.com'],
            [
                'name' => 'Admin',
                'first_name' => 'Admin',
                'email' => 'admin@yopmail.com',
                'role' => '1',
                'password' => Hash::make('123456'),
            ]
        );
    }
}
