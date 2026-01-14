<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Posyandu;
use App\Models\Ibu;
use App\Models\Anak;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Posyandus
        $posyandus = [
            [
                'nama' => 'Posyandu Mawar',
                'desa' => 'Desa Sukamaju',
                'kecamatan' => 'Kecamatan Sehat',
                'kabupaten' => 'Kabupaten Sejahtera',
                'alamat' => 'Jl. Posyandu No. 1',
                'kader_utama' => 'Ibu Siti',
                'telepon' => '08123456789',
                'aktif' => true,
            ],
            [
                'nama' => 'Posyandu Melati',
                'desa' => 'Desa Sukamaju',
                'kecamatan' => 'Kecamatan Sehat',
                'kabupaten' => 'Kabupaten Sejahtera',
                'alamat' => 'Jl. Melati No. 2',
                'kader_utama' => 'Ibu Ani',
                'telepon' => '08123456790',
                'aktif' => true,
            ],
            [
                'nama' => 'Posyandu Dahlia',
                'desa' => 'Desa Harapan',
                'kecamatan' => 'Kecamatan Sehat',
                'kabupaten' => 'Kabupaten Sejahtera',
                'alamat' => 'Jl. Dahlia No. 3',
                'kader_utama' => 'Ibu Rina',
                'telepon' => '08123456791',
                'aktif' => true,
            ],
        ];

        foreach ($posyandus as $data) {
            Posyandu::create($data);
        }

        // Create Admin Puskesmas
        User::create([
            'name' => 'Admin Puskesmas',
            'email' => 'admin@lentera.test',
            'password' => Hash::make('password'),
            'role' => 'admin_puskesmas',
            'posyandu_id' => null,
            'nip' => '198001012010001001',
            'telepon' => '08111222333',
            'aktif' => true,
        ]);

        // Create Kader for each Posyandu
        $kaders = [
            ['name' => 'Siti Rahayu', 'email' => 'siti@lentera.test', 'posyandu_id' => 1],
            ['name' => 'Ani Sulistyowati', 'email' => 'ani@lentera.test', 'posyandu_id' => 2],
            ['name' => 'Rina Wulandari', 'email' => 'rina@lentera.test', 'posyandu_id' => 3],
        ];

        foreach ($kaders as $kader) {
            User::create([
                'name' => $kader['name'],
                'email' => $kader['email'],
                'password' => Hash::make('password'),
                'role' => 'kader',
                'posyandu_id' => $kader['posyandu_id'],
                'telepon' => '0812345' . rand(1000, 9999),
                'aktif' => true,
            ]);
        }

        // Create sample Ibus (Mothers)
        $ibus = [
            [
                'nik' => '3201010101010001',
                'nama' => 'Dewi Sartika',
                'tanggal_lahir' => '1990-05-15',
                'tempat_lahir' => 'Bandung',
                'alamat' => 'Jl. Mawar No. 10',
                'rt' => '01',
                'rw' => '02',
                'desa' => 'Desa Sukamaju',
                'telepon' => '08234567890',
                'nama_suami' => 'Budi Santoso',
                'pekerjaan' => 'Ibu Rumah Tangga',
                'posyandu_id' => 1,
            ],
            [
                'nik' => '3201010101010002',
                'nama' => 'Ratna Kusuma',
                'tanggal_lahir' => '1992-08-20',
                'tempat_lahir' => 'Jakarta',
                'alamat' => 'Jl. Melati No. 5',
                'rt' => '03',
                'rw' => '01',
                'desa' => 'Desa Sukamaju',
                'telepon' => '08234567891',
                'nama_suami' => 'Agus Wijaya',
                'pekerjaan' => 'Pedagang',
                'posyandu_id' => 1,
            ],
            [
                'nik' => '3201010101010003',
                'nama' => 'Yuli Astuti',
                'tanggal_lahir' => '1988-12-10',
                'tempat_lahir' => 'Surabaya',
                'alamat' => 'Jl. Dahlia No. 8',
                'rt' => '02',
                'rw' => '03',
                'desa' => 'Desa Harapan',
                'telepon' => '08234567892',
                'nama_suami' => 'Dedi Prasetyo',
                'pekerjaan' => 'Guru',
                'posyandu_id' => 3,
            ],
        ];

        foreach ($ibus as $data) {
            Ibu::create($data);
        }

        // Create sample Anaks (Children)
        $anaks = [
            // Children for Dewi Sartika
            [
                'nama' => 'Ahmad Fauzi',
                'nik' => '3201010101019001',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => Carbon::now()->subMonths(24),
                'tempat_lahir' => 'Bandung',
                'ibu_id' => 1,
                'posyandu_id' => 1,
                'urutan_anak' => 1,
                'berat_lahir' => 3.2,
                'panjang_lahir' => 50,
                'lingkar_kepala_lahir' => 34,
            ],
            [
                'nama' => 'Siti Aisyah',
                'nik' => '3201010101019002',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => Carbon::now()->subMonths(8),
                'tempat_lahir' => 'Bandung',
                'ibu_id' => 1,
                'posyandu_id' => 1,
                'urutan_anak' => 2,
                'berat_lahir' => 3.0,
                'panjang_lahir' => 48,
                'lingkar_kepala_lahir' => 33,
            ],
            // Child for Ratna Kusuma
            [
                'nama' => 'Rafi Pratama',
                'nik' => '3201010101019003',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => Carbon::now()->subMonths(36),
                'tempat_lahir' => 'Jakarta',
                'ibu_id' => 2,
                'posyandu_id' => 1,
                'urutan_anak' => 1,
                'berat_lahir' => 3.5,
                'panjang_lahir' => 51,
                'lingkar_kepala_lahir' => 35,
            ],
            // Child for Yuli Astuti
            [
                'nama' => 'Putri Ayu',
                'nik' => '3201010101019004',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => Carbon::now()->subMonths(18),
                'tempat_lahir' => 'Surabaya',
                'ibu_id' => 3,
                'posyandu_id' => 3,
                'urutan_anak' => 1,
                'berat_lahir' => 2.9,
                'panjang_lahir' => 47,
                'lingkar_kepala_lahir' => 32,
            ],
        ];

        foreach ($anaks as $data) {
            Anak::create($data);
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('');
        $this->command->info('Login credentials:');
        $this->command->info('Admin Puskesmas: admin@lentera.test / password');
        $this->command->info('Kader Mawar: siti@lentera.test / password');
        $this->command->info('Kader Melati: ani@lentera.test / password');
        $this->command->info('Kader Dahlia: rina@lentera.test / password');
    }
}
