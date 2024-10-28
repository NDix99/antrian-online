<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Membuat user admin
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456789'), // Password default
            'role' => 'admin',
        ]);
        
        // Assign role admin ke user
        $admin->assignRole('admin');

        // Membuat user loket
        $loket = User::create([
            'name' => 'Loket',
            'email' => 'loket@gmail.com',
            'password' => Hash::make('123456789'), // Password default
            'role' => 'loket',
        ]);
    }
}