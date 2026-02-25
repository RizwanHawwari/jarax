<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class SetupSeeder extends Seeder
{
    public function run(): void
    {
        // Create backups directory
        $path = storage_path('app/public/backups');
        if (!file_exists($path)) {
            mkdir($path, 0775, true);
            $this->command->info('✅ Backup directory created: ' . $path);
        } else {
            $this->command->info('✓ Backup directory already exists');
        }

        // Create storage link
        if (!file_exists(public_path('storage'))) {
            \Artisan::call('storage:link');
            $this->command->info('✅ Storage link created');
        }
    }
}