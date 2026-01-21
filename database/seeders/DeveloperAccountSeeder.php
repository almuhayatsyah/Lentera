<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DeveloperAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create developer account (protected by email, cannot be deleted)
        // This account is protected in UserController and BackupController
        User::firstOrCreate(
            ['email' => 'developer@lentera.app'],
            [
                'name' => 'Developer',
                'email' => 'developer@lentera.app',
                'password' => Hash::make('developer123'),
                'role' => 'admin_puskesmas', // Using admin role
                'posyandu_id' => null,
                'aktif' => true,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Developer account created successfully!');
        $this->command->info('Email: developer@lentera.app');
        $this->command->info('Password: developer123');
        $this->command->warn('This account is protected and cannot be deleted.');
    }
}
