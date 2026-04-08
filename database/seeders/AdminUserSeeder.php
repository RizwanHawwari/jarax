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
        // ==================== ADMIN ====================
        if (!User::where('email', 'admin@jarax.com')->exists()) {
            User::create([
                'first_name'    => 'Super',
                'last_name'     => 'Admin',
                'email'         => 'admin@jarax.com',
                'phone_number'  => '081234567890',
                'address'       => 'Jl. Sudirman No. 123, Kec. Menteng',
                'city'          => 'Jakarta Pusat',
                'postal_code'   => '10310',
                'password'      => Hash::make('password'),
                'role'          => UserRole::ADMIN->value,
                'is_active'     => true,
            ]);
            $this->command->info('✅ Admin user created! (admin@jarax.com / password)');
        }

        // ==================== PETUGAS ====================
        if (!User::where('email', 'petugas@jarax.com')->exists()) {
            User::create([
                'first_name'    => 'Budi',
                'last_name'     => 'Santoso',
                'email'         => 'petugas@jarax.com',
                'phone_number'  => '081234567891',
                'address'       => 'Jl. Raya Bogor Km. 28, Kec. Cimanggis',
                'city'          => 'Depok',
                'postal_code'   => '16451',
                'password'      => Hash::make('password'),
                'role'          => UserRole::PETUGAS->value,
                'is_active'     => true,
                'position'      => 'verifikasi',
                'staff_status'  => 'active',
            ]);
            $this->command->info('✅ Petugas user created! (petugas@jarax.com / password)');
        }

        // ==================== USER BIASA (untuk testing) ====================
        $users = [
            [
                'first_name' => 'Budi',
                'last_name'  => 'Santoso',
                'email'      => 'budi@jarax.com',
                'phone'      => '081234567892',
                'address'    => 'Jl. Melati No. 45, RT 03 RW 07',
                'city'       => 'Jakarta Selatan',
                'postal_code'=> '12430',
            ],
            [
                'first_name' => 'Siti',
                'last_name'  => 'Aminah',
                'email'      => 'siti@jarax.com',
                'phone'      => '081234567893',
                'address'    => 'Perumahan Griya Asri Blok C12',
                'city'       => 'Bandung',
                'postal_code'=> '40123',
            ],
            [
                'first_name' => 'Ahmad',
                'last_name'  => 'Rizki',
                'email'      => 'ahmad@jarax.com',
                'phone'      => '081234567894',
                'address'    => 'Jl. Veteran No. 87',
                'city'       => 'Surabaya',
                'postal_code'=> '60123',
            ],
            [
                'first_name' => 'Dewi',
                'last_name'  => 'Lestari',
                'email'      => 'dewi@jarax.com',
                'phone'      => '081234567895',
                'address'    => 'Komplek Permata Hijau Blok D5',
                'city'       => 'Yogyakarta',
                'postal_code'=> '55123',
            ],
            [
                'first_name' => 'Eko',
                'last_name'  => 'Prasetyo',
                'email'      => 'eko@jarax.com',
                'phone'      => '081234567896',
                'address'    => 'Jl. Ahmad Yani No. 234',
                'city'       => 'Semarang',
                'postal_code'=> '50234',
            ],
        ];

        foreach ($users as $data) {
            if (!User::where('email', $data['email'])->exists()) {
                User::create([
                    'first_name'   => $data['first_name'],
                    'last_name'    => $data['last_name'],
                    'email'        => $data['email'],
                    'phone_number' => $data['phone'],
                    'address'      => $data['address'],
                    'city'         => $data['city'],
                    'postal_code'  => $data['postal_code'],
                    'password'     => Hash::make('password'),
                    'role'         => UserRole::USER->value,
                    'is_active'    => true,
                ]);
                $this->command->info("✅ User created! ({$data['email']} / password)");
            }
        }

        $this->command->info('🎉 Semua user seeder berhasil dijalankan dengan data alamat!');
    }
}