<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::where('email', 'admin@jarax.com')->first();
        if (!$admin) {
            User::create([
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'email' => 'admin@jarax.com',
                'phone_number' => '081234567890',
                'password' => Hash::make('password'),
                'role' => UserRole::ADMIN->value,
            ]);
            $this->command->info('✅ Admin user created! (admin@jarax.com / password)');
        }

        // Petugas
        $petugas = User::where('email', 'petugas@jarax.com')->first();
        if (!$petugas) {
            User::create([
                'first_name' => 'Petugas',
                'last_name' => 'Satu',
                'email' => 'petugas@jarax.com',
                'phone_number' => '081234567891',
                'password' => Hash::make('password'),
                'role' => UserRole::PETUGAS->value,
            ]);
            $this->command->info('✅ Petugas user created! (petugas@jarax.com / password)');
        }

        // User biasa (beberapa untuk testing)
        $users = [
            ['first_name' => 'Budi', 'last_name' => 'Santoso', 'email' => 'budi@jarax.com', 'phone' => '081234567892'],
            ['first_name' => 'Siti', 'last_name' => 'Aminah', 'email' => 'siti@jarax.com', 'phone' => '081234567893'],
            ['first_name' => 'Ahmad', 'last_name' => 'Rizki', 'email' => 'ahmad@jarax.com', 'phone' => '081234567894'],
            ['first_name' => 'Dewi', 'last_name' => 'Lestari', 'email' => 'dewi@jarax.com', 'phone' => '081234567895'],
            ['first_name' => 'Eko', 'last_name' => 'Prasetyo', 'email' => 'eko@jarax.com', 'phone' => '081234567896'],
        ];

        foreach ($users as $userData) {
            $user = User::where('email', $userData['email'])->first();
            if (!$user) {
                User::create([
                    'first_name' => $userData['first_name'],
                    'last_name' => $userData['last_name'],
                    'email' => $userData['email'],
                    'phone_number' => $userData['phone'],
                    'password' => Hash::make('password'),
                    'role' => UserRole::USER->value,
                ]);
                $this->command->info("✅ User created! ({$userData['email']} / password)");
            }
        }
    }
}