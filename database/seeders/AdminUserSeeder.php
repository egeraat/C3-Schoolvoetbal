<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    if (User::where('email', 'admin@example.com')->exists()) {
        echo "Admin user already exists. No changes made.\n";
    } else {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'), // Dit wordt niet gebruikt als het account al bestaat
            'is_admin' => true,
        ]);

        echo "Admin user has been created.\n";
    }
}
}
