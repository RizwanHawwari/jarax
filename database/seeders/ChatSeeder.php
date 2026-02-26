<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', UserRole::USER->value)->get();
        $admin = User::where('role', UserRole::ADMIN->value)->first();

        if (!$admin) return;

        foreach ($users->take(3) as $user) {
            // User message
            Chat::create([
                'user_id' => $user->id,
                'admin_id' => $admin->id,
                'message' => 'Halo min, apakah sepatu ukuran 42 warna putih ready?',
                'sender' => 'user',
                'is_read' => true,
            ]);

            // Admin reply
            Chat::create([
                'user_id' => $user->id,
                'admin_id' => $admin->id,
                'message' => 'Halo kak! Ready stok untuk ukuran 42 warna putih. Silakan diorder ya, pembayaran sebelum jam 14.00 dikirim hari ini juga! 🚀',
                'sender' => 'admin',
                'is_read' => false,
            ]);
        }

        $this->command->info('✅ Chat seeder completed!');
    }
}
