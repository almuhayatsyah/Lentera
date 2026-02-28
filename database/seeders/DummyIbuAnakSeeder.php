<?php

namespace Database\Seeders;

use App\Models\Ibu;
use App\Models\Anak;
use App\Models\Posyandu;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DummyIbuAnakSeeder extends Seeder
{
    /**
     * Seed 10 Ibu (mothers) and 10 Anak (children) with realistic dummy data.
     * Each Ibu gets 1 child, distributed across available Posyandus.
     */
    public function run(): void
    {
        // Get existing posyandu IDs
        $posyanduIds = Posyandu::pluck('id')->toArray();

        if (empty($posyanduIds)) {
            $this->command->error('Tidak ada data Posyandu! Jalankan DatabaseSeeder terlebih dahulu.');
            return;
        }

        // =============================================
        // 10 Data Ibu
        // =============================================
        $ibus = [
            [
                'nik'            => '3201020304050001',
                'nama'           => 'Nurhasanah',
                'tanggal_lahir'  => '1993-03-12',
                'tempat_lahir'   => 'Bogor',
                'alamat'         => 'Jl. Kenanga No. 5',
                'rt'             => '01',
                'rw'             => '01',
                'desa'           => 'Desa Sukamaju',
                'telepon'        => '081234560001',
                'nama_suami'     => 'Hendra Saputra',
                'pekerjaan'      => 'Ibu Rumah Tangga',
                'posyandu_id'    => $posyanduIds[0],
                'aktif'          => true,
            ],
            [
                'nik'            => '3201020304050002',
                'nama'           => 'Sri Wahyuni',
                'tanggal_lahir'  => '1991-07-25',
                'tempat_lahir'   => 'Semarang',
                'alamat'         => 'Jl. Anggrek No. 12',
                'rt'             => '02',
                'rw'             => '01',
                'desa'           => 'Desa Sukamaju',
                'telepon'        => '081234560002',
                'nama_suami'     => 'Eko Prasetyo',
                'pekerjaan'      => 'Pedagang',
                'posyandu_id'    => $posyanduIds[0],
                'aktif'          => true,
            ],
            [
                'nik'            => '3201020304050003',
                'nama'           => 'Rina Marlina',
                'tanggal_lahir'  => '1994-11-08',
                'tempat_lahir'   => 'Bandung',
                'alamat'         => 'Jl. Cempaka No. 3',
                'rt'             => '03',
                'rw'             => '02',
                'desa'           => 'Desa Sukamaju',
                'telepon'        => '081234560003',
                'nama_suami'     => 'Ridwan Kamil',
                'pekerjaan'      => 'Wiraswasta',
                'posyandu_id'    => $posyanduIds[0],
                'aktif'          => true,
            ],
            [
                'nik'            => '3201020304050004',
                'nama'           => 'Fitri Handayani',
                'tanggal_lahir'  => '1989-01-20',
                'tempat_lahir'   => 'Yogyakarta',
                'alamat'         => 'Jl. Bougenville No. 7',
                'rt'             => '01',
                'rw'             => '03',
                'desa'           => 'Desa Sukamaju',
                'telepon'        => '081234560004',
                'nama_suami'     => 'Joko Widodo',
                'pekerjaan'      => 'Guru',
                'posyandu_id'    => $posyanduIds[0 % count($posyanduIds)],
                'aktif'          => true,
            ],
            [
                'nik'            => '3201020304050005',
                'nama'           => 'Lestari Ningrum',
                'tanggal_lahir'  => '1995-06-30',
                'tempat_lahir'   => 'Solo',
                'alamat'         => 'Jl. Flamboyan No. 9',
                'rt'             => '02',
                'rw'             => '02',
                'desa'           => 'Desa Sukamaju',
                'telepon'        => '081234560005',
                'nama_suami'     => 'Bambang Sutrisno',
                'pekerjaan'      => 'Ibu Rumah Tangga',
                'posyandu_id'    => $posyanduIds[1 % count($posyanduIds)],
                'aktif'          => true,
            ],
            [
                'nik'            => '3201020304050006',
                'nama'           => 'Wulandari Sari',
                'tanggal_lahir'  => '1990-09-14',
                'tempat_lahir'   => 'Malang',
                'alamat'         => 'Jl. Sakura No. 15',
                'rt'             => '01',
                'rw'             => '01',
                'desa'           => 'Desa Harapan',
                'telepon'        => '081234560006',
                'nama_suami'     => 'Sigit Purnomo',
                'pekerjaan'      => 'Perawat',
                'posyandu_id'    => $posyanduIds[1 % count($posyanduIds)],
                'aktif'          => true,
            ],
            [
                'nik'            => '3201020304050007',
                'nama'           => 'Kartini Dewi',
                'tanggal_lahir'  => '1992-04-21',
                'tempat_lahir'   => 'Cirebon',
                'alamat'         => 'Jl. Tulip No. 20',
                'rt'             => '03',
                'rw'             => '01',
                'desa'           => 'Desa Harapan',
                'telepon'        => '081234560007',
                'nama_suami'     => 'Andi Firmansyah',
                'pekerjaan'      => 'Karyawan Swasta',
                'posyandu_id'    => $posyanduIds[2 % count($posyanduIds)],
                'aktif'          => true,
            ],
            [
                'nik'            => '3201020304050008',
                'nama'           => 'Megawati Putri',
                'tanggal_lahir'  => '1996-02-17',
                'tempat_lahir'   => 'Depok',
                'alamat'         => 'Jl. Teratai No. 6',
                'rt'             => '02',
                'rw'             => '03',
                'desa'           => 'Desa Harapan',
                'telepon'        => '081234560008',
                'nama_suami'     => 'Rizky Maulana',
                'pekerjaan'      => 'Ibu Rumah Tangga',
                'posyandu_id'    => $posyanduIds[2 % count($posyanduIds)],
                'aktif'          => true,
            ],
            [
                'nik'            => '3201020304050009',
                'nama'           => 'Indah Permata',
                'tanggal_lahir'  => '1993-10-05',
                'tempat_lahir'   => 'Tangerang',
                'alamat'         => 'Jl. Lavender No. 11',
                'rt'             => '01',
                'rw'             => '02',
                'desa'           => 'Desa Harapan',
                'telepon'        => '081234560009',
                'nama_suami'     => 'Fajar Nugroho',
                'pekerjaan'      => 'Pedagang',
                'posyandu_id'    => $posyanduIds[2 % count($posyanduIds)],
                'aktif'          => true,
            ],
            [
                'nik'            => '3201020304050010',
                'nama'           => 'Siska Amelia',
                'tanggal_lahir'  => '1997-12-28',
                'tempat_lahir'   => 'Bekasi',
                'alamat'         => 'Jl. Kamboja No. 4',
                'rt'             => '03',
                'rw'             => '03',
                'desa'           => 'Desa Harapan',
                'telepon'        => '081234560010',
                'nama_suami'     => 'Wahyu Hidayat',
                'pekerjaan'      => 'Ibu Rumah Tangga',
                'posyandu_id'    => $posyanduIds[2 % count($posyanduIds)],
                'aktif'          => true,
            ],
        ];

        $createdIbus = [];
        foreach ($ibus as $data) {
            $createdIbus[] = Ibu::create($data);
        }

        $this->command->info('✅ 10 data Ibu berhasil ditambahkan!');

        // =============================================
        // 10 Data Anak (1 anak per ibu)
        // =============================================
        $anaks = [
            [
                'nama'                 => 'Muhammad Rizky',
                'nik'                  => '3201020304059001',
                'jenis_kelamin'        => 'L',
                'tanggal_lahir'        => Carbon::now()->subMonths(30),  // 2 tahun 6 bulan
                'tempat_lahir'         => 'Bogor',
                'ibu_id'              => $createdIbus[0]->id,
                'posyandu_id'         => $createdIbus[0]->posyandu_id,
                'urutan_anak'          => 1,
                'berat_lahir'          => 3.10,
                'panjang_lahir'        => 49.00,
                'lingkar_kepala_lahir' => 33.5,
                'golongan_darah'       => 'A',
                'aktif'                => true,
            ],
            [
                'nama'                 => 'Zahra Aulia',
                'nik'                  => '3201020304059002',
                'jenis_kelamin'        => 'P',
                'tanggal_lahir'        => Carbon::now()->subMonths(18),  // 1 tahun 6 bulan
                'tempat_lahir'         => 'Semarang',
                'ibu_id'              => $createdIbus[1]->id,
                'posyandu_id'         => $createdIbus[1]->posyandu_id,
                'urutan_anak'          => 1,
                'berat_lahir'          => 2.90,
                'panjang_lahir'        => 48.00,
                'lingkar_kepala_lahir' => 33.0,
                'golongan_darah'       => 'B',
                'aktif'                => true,
            ],
            [
                'nama'                 => 'Dimas Pratama',
                'nik'                  => '3201020304059003',
                'jenis_kelamin'        => 'L',
                'tanggal_lahir'        => Carbon::now()->subMonths(42),  // 3 tahun 6 bulan
                'tempat_lahir'         => 'Bandung',
                'ibu_id'              => $createdIbus[2]->id,
                'posyandu_id'         => $createdIbus[2]->posyandu_id,
                'urutan_anak'          => 1,
                'berat_lahir'          => 3.40,
                'panjang_lahir'        => 51.00,
                'lingkar_kepala_lahir' => 34.5,
                'golongan_darah'       => 'O',
                'aktif'                => true,
            ],
            [
                'nama'                 => 'Aisyah Putri',
                'nik'                  => '3201020304059004',
                'jenis_kelamin'        => 'P',
                'tanggal_lahir'        => Carbon::now()->subMonths(12),  // 1 tahun
                'tempat_lahir'         => 'Yogyakarta',
                'ibu_id'              => $createdIbus[3]->id,
                'posyandu_id'         => $createdIbus[3]->posyandu_id,
                'urutan_anak'          => 1,
                'berat_lahir'          => 3.00,
                'panjang_lahir'        => 49.50,
                'lingkar_kepala_lahir' => 34.0,
                'golongan_darah'       => 'AB',
                'aktif'                => true,
            ],
            [
                'nama'                 => 'Farhan Maulana',
                'nik'                  => '3201020304059005',
                'jenis_kelamin'        => 'L',
                'tanggal_lahir'        => Carbon::now()->subMonths(6),   // 6 bulan
                'tempat_lahir'         => 'Solo',
                'ibu_id'              => $createdIbus[4]->id,
                'posyandu_id'         => $createdIbus[4]->posyandu_id,
                'urutan_anak'          => 1,
                'berat_lahir'          => 3.30,
                'panjang_lahir'        => 50.00,
                'lingkar_kepala_lahir' => 34.0,
                'golongan_darah'       => 'A',
                'aktif'                => true,
            ],
            [
                'nama'                 => 'Nayla Safitri',
                'nik'                  => '3201020304059006',
                'jenis_kelamin'        => 'P',
                'tanggal_lahir'        => Carbon::now()->subMonths(48),  // 4 tahun
                'tempat_lahir'         => 'Malang',
                'ibu_id'              => $createdIbus[5]->id,
                'posyandu_id'         => $createdIbus[5]->posyandu_id,
                'urutan_anak'          => 1,
                'berat_lahir'          => 2.80,
                'panjang_lahir'        => 47.00,
                'lingkar_kepala_lahir' => 32.5,
                'golongan_darah'       => 'B',
                'aktif'                => true,
            ],
            [
                'nama'                 => 'Alif Hidayat',
                'nik'                  => '3201020304059007',
                'jenis_kelamin'        => 'L',
                'tanggal_lahir'        => Carbon::now()->subMonths(10),  // 10 bulan
                'tempat_lahir'         => 'Cirebon',
                'ibu_id'              => $createdIbus[6]->id,
                'posyandu_id'         => $createdIbus[6]->posyandu_id,
                'urutan_anak'          => 1,
                'berat_lahir'          => 3.50,
                'panjang_lahir'        => 52.00,
                'lingkar_kepala_lahir' => 35.0,
                'golongan_darah'       => 'O',
                'aktif'                => true,
            ],
            [
                'nama'                 => 'Keisha Ramadhani',
                'nik'                  => '3201020304059008',
                'jenis_kelamin'        => 'P',
                'tanggal_lahir'        => Carbon::now()->subMonths(24),  // 2 tahun
                'tempat_lahir'         => 'Depok',
                'ibu_id'              => $createdIbus[7]->id,
                'posyandu_id'         => $createdIbus[7]->posyandu_id,
                'urutan_anak'          => 1,
                'berat_lahir'          => 3.20,
                'panjang_lahir'        => 50.00,
                'lingkar_kepala_lahir' => 34.0,
                'golongan_darah'       => 'A',
                'aktif'                => true,
            ],
            [
                'nama'                 => 'Rafif Akbar',
                'nik'                  => '3201020304059009',
                'jenis_kelamin'        => 'L',
                'tanggal_lahir'        => Carbon::now()->subMonths(36),  // 3 tahun
                'tempat_lahir'         => 'Tangerang',
                'ibu_id'              => $createdIbus[8]->id,
                'posyandu_id'         => $createdIbus[8]->posyandu_id,
                'urutan_anak'          => 1,
                'berat_lahir'          => 3.60,
                'panjang_lahir'        => 51.50,
                'lingkar_kepala_lahir' => 35.0,
                'golongan_darah'       => 'AB',
                'aktif'                => true,
            ],
            [
                'nama'                 => 'Cantika Maharani',
                'nik'                  => '3201020304059010',
                'jenis_kelamin'        => 'P',
                'tanggal_lahir'        => Carbon::now()->subMonths(3),   // 3 bulan
                'tempat_lahir'         => 'Bekasi',
                'ibu_id'              => $createdIbus[9]->id,
                'posyandu_id'         => $createdIbus[9]->posyandu_id,
                'urutan_anak'          => 1,
                'berat_lahir'          => 3.15,
                'panjang_lahir'        => 49.00,
                'lingkar_kepala_lahir' => 33.5,
                'golongan_darah'       => 'O',
                'aktif'                => true,
            ],
        ];

        foreach ($anaks as $data) {
            Anak::create($data);
        }

        $this->command->info('✅ 10 data Anak berhasil ditambahkan!');
        $this->command->info('');
        $this->command->info('📋 Ringkasan data dummy:');
        $this->command->info('   Ibu  : Nurhasanah, Sri Wahyuni, Rina Marlina, Fitri Handayani,');
        $this->command->info('          Lestari Ningrum, Wulandari Sari, Kartini Dewi,');
        $this->command->info('          Megawati Putri, Indah Permata, Siska Amelia');
        $this->command->info('   Anak : Muhammad Rizky (L, 30bln), Zahra Aulia (P, 18bln),');
        $this->command->info('          Dimas Pratama (L, 42bln), Aisyah Putri (P, 12bln),');
        $this->command->info('          Farhan Maulana (L, 6bln), Nayla Safitri (P, 48bln),');
        $this->command->info('          Alif Hidayat (L, 10bln), Keisha Ramadhani (P, 24bln),');
        $this->command->info('          Rafif Akbar (L, 36bln), Cantika Maharani (P, 3bln)');
    }
}
