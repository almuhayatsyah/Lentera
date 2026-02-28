<?php

namespace Database\Seeders;

use App\Models\Ibu;
use App\Models\Anak;
use App\Models\Posyandu;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DummyIbuAnakSeeder2 extends Seeder
{
    /**
     * Seed 5 Ibu (mothers) and 5 Anak (children) tambahan.
     */
    public function run(): void
    {
        $posyanduIds = Posyandu::pluck('id')->toArray();

        if (empty($posyanduIds)) {
            $this->command->error('Tidak ada data Posyandu! Jalankan DatabaseSeeder terlebih dahulu.');
            return;
        }

        // =============================================
        // 5 Data Ibu Tambahan
        // =============================================
        $ibus = [
            [
                'nik'            => '3201020304050011',
                'nama'           => 'Anisa Rahmawati',
                'tanggal_lahir'  => '1994-08-18',
                'tempat_lahir'   => 'Garut',
                'alamat'         => 'Jl. Seruni No. 8',
                'rt'             => '01',
                'rw'             => '04',
                'desa'           => 'Desa Sukamaju',
                'telepon'        => '081234560011',
                'nama_suami'     => 'Deni Kurniawan',
                'pekerjaan'      => 'Ibu Rumah Tangga',
                'posyandu_id'    => $posyanduIds[0],
                'aktif'          => true,
            ],
            [
                'nik'            => '3201020304050012',
                'nama'           => 'Dian Puspita',
                'tanggal_lahir'  => '1991-05-03',
                'tempat_lahir'   => 'Tasikmalaya',
                'alamat'         => 'Jl. Aster No. 14',
                'rt'             => '02',
                'rw'             => '04',
                'desa'           => 'Desa Sukamaju',
                'telepon'        => '081234560012',
                'nama_suami'     => 'Toni Setiawan',
                'pekerjaan'      => 'Penjahit',
                'posyandu_id'    => $posyanduIds[0],
                'aktif'          => true,
            ],
            [
                'nik'            => '3201020304050013',
                'nama'           => 'Hana Fitriani',
                'tanggal_lahir'  => '1996-01-22',
                'tempat_lahir'   => 'Sumedang',
                'alamat'         => 'Jl. Lili No. 3',
                'rt'             => '03',
                'rw'             => '02',
                'desa'           => 'Desa Harapan',
                'telepon'        => '081234560013',
                'nama_suami'     => 'Gilang Ramadhan',
                'pekerjaan'      => 'Bidan',
                'posyandu_id'    => $posyanduIds[1 % count($posyanduIds)],
                'aktif'          => true,
            ],
            [
                'nik'            => '3201020304050014',
                'nama'           => 'Novia Anggraini',
                'tanggal_lahir'  => '1993-11-09',
                'tempat_lahir'   => 'Cianjur',
                'alamat'         => 'Jl. Matahari No. 21',
                'rt'             => '01',
                'rw'             => '03',
                'desa'           => 'Desa Harapan',
                'telepon'        => '081234560014',
                'nama_suami'     => 'Arif Rahman',
                'pekerjaan'      => 'Wiraswasta',
                'posyandu_id'    => $posyanduIds[2 % count($posyanduIds)],
                'aktif'          => true,
            ],
            [
                'nik'            => '3201020304050015',
                'nama'           => 'Riska Oktaviani',
                'tanggal_lahir'  => '1995-10-15',
                'tempat_lahir'   => 'Sukabumi',
                'alamat'         => 'Jl. Pelangi No. 17',
                'rt'             => '02',
                'rw'             => '01',
                'desa'           => 'Desa Harapan',
                'telepon'        => '081234560015',
                'nama_suami'     => 'Yusuf Hakim',
                'pekerjaan'      => 'Ibu Rumah Tangga',
                'posyandu_id'    => $posyanduIds[2 % count($posyanduIds)],
                'aktif'          => true,
            ],
        ];

        $createdIbus = [];
        foreach ($ibus as $data) {
            $createdIbus[] = Ibu::create($data);
        }

        $this->command->info('✅ 5 data Ibu tambahan berhasil ditambahkan!');

        // =============================================
        // 5 Data Anak Tambahan (1 anak per ibu)
        // =============================================
        $anaks = [
            [
                'nama'                 => 'Nabil Arkaan',
                'nik'                  => '3201020304059011',
                'jenis_kelamin'        => 'L',
                'tanggal_lahir'        => Carbon::now()->subMonths(15),  // 1 tahun 3 bulan
                'tempat_lahir'         => 'Garut',
                'ibu_id'              => $createdIbus[0]->id,
                'posyandu_id'         => $createdIbus[0]->posyandu_id,
                'urutan_anak'          => 1,
                'berat_lahir'          => 3.25,
                'panjang_lahir'        => 50.00,
                'lingkar_kepala_lahir' => 34.0,
                'golongan_darah'       => 'B',
                'aktif'                => true,
            ],
            [
                'nama'                 => 'Salwa Khairunnisa',
                'nik'                  => '3201020304059012',
                'jenis_kelamin'        => 'P',
                'tanggal_lahir'        => Carbon::now()->subMonths(54),  // 4 tahun 6 bulan
                'tempat_lahir'         => 'Tasikmalaya',
                'ibu_id'              => $createdIbus[1]->id,
                'posyandu_id'         => $createdIbus[1]->posyandu_id,
                'urutan_anak'          => 1,
                'berat_lahir'          => 2.75,
                'panjang_lahir'        => 46.50,
                'lingkar_kepala_lahir' => 32.0,
                'golongan_darah'       => 'O',
                'aktif'                => true,
            ],
            [
                'nama'                 => 'Azzam Mubarak',
                'nik'                  => '3201020304059013',
                'jenis_kelamin'        => 'L',
                'tanggal_lahir'        => Carbon::now()->subMonths(9),   // 9 bulan
                'tempat_lahir'         => 'Sumedang',
                'ibu_id'              => $createdIbus[2]->id,
                'posyandu_id'         => $createdIbus[2]->posyandu_id,
                'urutan_anak'          => 1,
                'berat_lahir'          => 3.45,
                'panjang_lahir'        => 51.00,
                'lingkar_kepala_lahir' => 34.5,
                'golongan_darah'       => 'A',
                'aktif'                => true,
            ],
            [
                'nama'                 => 'Kayla Zahra',
                'nik'                  => '3201020304059014',
                'jenis_kelamin'        => 'P',
                'tanggal_lahir'        => Carbon::now()->subMonths(20),  // 1 tahun 8 bulan
                'tempat_lahir'         => 'Cianjur',
                'ibu_id'              => $createdIbus[3]->id,
                'posyandu_id'         => $createdIbus[3]->posyandu_id,
                'urutan_anak'          => 1,
                'berat_lahir'          => 3.05,
                'panjang_lahir'        => 48.50,
                'lingkar_kepala_lahir' => 33.0,
                'golongan_darah'       => 'AB',
                'aktif'                => true,
            ],
            [
                'nama'                 => 'Hafiz Raditya',
                'nik'                  => '3201020304059015',
                'jenis_kelamin'        => 'L',
                'tanggal_lahir'        => Carbon::now()->subMonths(28),  // 2 tahun 4 bulan
                'tempat_lahir'         => 'Sukabumi',
                'ibu_id'              => $createdIbus[4]->id,
                'posyandu_id'         => $createdIbus[4]->posyandu_id,
                'urutan_anak'          => 1,
                'berat_lahir'          => 3.35,
                'panjang_lahir'        => 50.50,
                'lingkar_kepala_lahir' => 34.5,
                'golongan_darah'       => 'O',
                'aktif'                => true,
            ],
        ];

        foreach ($anaks as $data) {
            Anak::create($data);
        }

        $this->command->info('✅ 5 data Anak tambahan berhasil ditambahkan!');
        $this->command->info('');
        $this->command->info('📋 Ringkasan data dummy tambahan:');
        $this->command->info('   Ibu  : Anisa Rahmawati, Dian Puspita, Hana Fitriani,');
        $this->command->info('          Novia Anggraini, Riska Oktaviani');
        $this->command->info('   Anak : Nabil Arkaan (L, 15bln), Salwa Khairunnisa (P, 54bln),');
        $this->command->info('          Azzam Mubarak (L, 9bln), Kayla Zahra (P, 20bln),');
        $this->command->info('          Hafiz Raditya (L, 28bln)');
    }
}
