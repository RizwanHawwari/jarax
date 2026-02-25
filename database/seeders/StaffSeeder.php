<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        $staffs = [
            [
                'first_name' => 'Siti',
                'last_name' => 'Aminah',
                'email' => 'siti@jarax.com',
                'phone' => '081234567891',
                'position' => 'gudang',
                'staff_status' => 'active',
            ],
            [
                'first_name' => 'Rudi',
                'last_name' => 'Hartono',
                'email' => 'rudi@jarax.com',
                'phone' => '081234567892',
                'position' => 'verifikasi',
                'staff_status' => 'cuti',
            ],
            [
                'first_name' => 'Dewi',
                'last_name' => 'Kusuma',
                'email' => 'dewi.cs@jarax.com',
                'phone' => '081234567893',
                'position' => 'cs',
                'staff_status' => 'active',
            ],
            [
                'first_name' => 'Andi',
                'last_name' => 'Pratama',
                'email' => 'andi@jarax.com',
                'phone' => '081234567894',
                'position' => 'shipping',
                'staff_status' => 'active',
            ],
        ];

        foreach ($staffs as $staffData) {
            $staff = User::where('email', $staffData['email'])->first();
            if (!$staff) {
                User::create([
                    'first_name' => $staffData['first_name'],
                    'last_name' => $staffData['last_name'],
                    'email' => $staffData['email'],
                    'phone_number' => $staffData['phone'],
                    'password' => Hash::make('password'),
                    'role' => UserRole::PETUGAS->value,
                    'position' => $staffData['position'],
                    'staff_status' => $staffData['staff_status'],
                    'join_date' => now()->subDays(rand(30, 365)),
                    'staff_code' => 'ST-' . str_pad(User::where('role', UserRole::PETUGAS->value)->count() + 1, 4, '0', STR_PAD_LEFT),
                ]);
                $this->command->info("✅ Staff created: {$staffData['first_name']} {$staffData['last_name']} ({$staffData['email']} / password)");
            }
        }

        $this->command->info('🎉 Staff seeding completed!');
    }
}