<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@schoolmapr.com'],
            [
                'name'     => 'SchoolMapr Admin',
                'password' => Hash::make('admin123'),
                'phone'    => '+91 9876543210',
            ]
        );

        $admin->assignRole('admin');
    }
}