<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@lentera.id'],
            [
                'name' => 'Administrator',
                'email' => 'admin@lentera.id',
                'nip' => '123456789',
                'password' => Hash::make('password123'),
                'role' => 'admin_puskesmas',
                'aktif' => true,
            ]
        );

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@lentera.id');
        $this->command->info('NIP: 123456789');
        $this->command->info('Password: password123');
    }
}
