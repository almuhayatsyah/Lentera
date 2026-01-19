<?php

namespace App\Exports;

use App\Models\Anak;
use App\Models\Kunjungan;
use App\Models\Pengukuran;
use App\Models\Posyandu;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SkdnExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize, WithTitle
{
    protected $bulan;
    protected $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function array(): array
    {
        $posyandus = Posyandu::with(['anaks' => function ($q) {
            $q->aktif()->balita();
        }])->get();

        $data = [];
        $no = 0;

        foreach ($posyandus as $posyandu) {
            $no++;
            
            // S = Sasaran (semua anak balita di posyandu)
            $sasaran = $posyandu->anaks->count();

            // K = Anak yang terdaftar di posyandu
            $terdaftar = $sasaran;

            // D = Ditimbang bulan ini
            $ditimbang = Kunjungan::where('posyandu_id', $posyandu->id)
                ->whereMonth('tanggal_kunjungan', $this->bulan)
                ->whereYear('tanggal_kunjungan', $this->tahun)
                ->distinct('anak_id')
                ->count('anak_id');

            // N = Berat badan naik
            $naikBb = Pengukuran::whereHas('kunjungan', function ($q) use ($posyandu) {
                $q->where('posyandu_id', $posyandu->id)
                  ->whereMonth('tanggal_kunjungan', $this->bulan)
                  ->whereYear('tanggal_kunjungan', $this->tahun);
            })->where('naik_berat_badan', true)->count();

            // Status counts
            $statusCounts = $this->getStatusCounts($posyandu->id);

            $data[] = [
                $no,
                $posyandu->nama,
                $sasaran,
                $terdaftar,
                $ditimbang,
                $naikBb,
                $sasaran > 0 ? round(($ditimbang / $sasaran) * 100, 1) . '%' : '0%',
                $ditimbang > 0 ? round(($naikBb / $ditimbang) * 100, 1) . '%' : '0%',
                $statusCounts['gizi_baik'],
                $statusCounts['gizi_kurang'],
                $statusCounts['gizi_buruk'],
                $statusCounts['stunting_normal'],
                $statusCounts['stunting_pendek'],
                $statusCounts['stunting_sangat_pendek'],
            ];
        }

        // Add total row
        $totalS = collect($data)->sum(2);
        $totalK = collect($data)->sum(3);
        $totalD = collect($data)->sum(4);
        $totalN = collect($data)->sum(5);

        $data[] = [
            '',
            'TOTAL',
            $totalS,
            $totalK,
            $totalD,
            $totalN,
            $totalS > 0 ? round(($totalD / $totalS) * 100, 1) . '%' : '0%',
            $totalD > 0 ? round(($totalN / $totalD) * 100, 1) . '%' : '0%',
            collect($data)->sum(8),
            collect($data)->sum(9),
            collect($data)->sum(10),
            collect($data)->sum(11),
            collect($data)->sum(12),
            collect($data)->sum(13),
        ];

        return $data;
    }

    public function headings(): array
    {
        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        return [
            'No',
            'Nama Posyandu',
            'S (Sasaran)',
            'K (Terdaftar)',
            'D (Ditimbang)',
            'N (BB Naik)',
            'D/S (%)',
            'N/D (%)',
            'Gizi Baik',
            'Gizi Kurang',
            'Gizi Buruk',
            'Normal',
            'Pendek',
            'Sangat Pendek',
        ];
    }

    public function title(): string
    {
        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        return 'SKDN ' . $namaBulan[$this->bulan] . ' ' . $this->tahun;
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();
        
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1E5799']
                ]
            ],
            $lastRow => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E2E8F0']
                ]
            ],
        ];
    }

    private function getStatusCounts($posyanduId): array
    {
        $pengukurans = Pengukuran::whereHas('kunjungan', function ($q) use ($posyanduId) {
            $q->where('posyandu_id', $posyanduId)
              ->whereMonth('tanggal_kunjungan', $this->bulan)
              ->whereYear('tanggal_kunjungan', $this->tahun);
        })->get();

        return [
            'gizi_baik' => $pengukurans->where('status_gizi', 'gizi_baik')->count(),
            'gizi_kurang' => $pengukurans->where('status_gizi', 'gizi_kurang')->count(),
            'gizi_buruk' => $pengukurans->where('status_gizi', 'gizi_buruk')->count(),
            'stunting_normal' => $pengukurans->where('status_stunting', 'normal')->count(),
            'stunting_pendek' => $pengukurans->where('status_stunting', 'pendek')->count(),
            'stunting_sangat_pendek' => $pengukurans->where('status_stunting', 'sangat_pendek')->count(),
        ];
    }
}
