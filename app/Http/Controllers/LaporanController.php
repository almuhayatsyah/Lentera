<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\Kunjungan;
use App\Models\Pengukuran;
use App\Models\Posyandu;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * SKDN Report
     * S = Sasaran (All children)
     * K = Anak yang punya KMS (registered)
     * D = Ditimbang (Weighed this month)
     * N = Naik berat badannya (Weight increased)
     */
    public function skdn(Request $request)
    {
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);

        $posyandus = Posyandu::with(['anaks' => function ($q) {
            $q->aktif()->balita();
        }])->get();

        $data = [];

        foreach ($posyandus as $posyandu) {
            // S = Sasaran (semua anak balita di posyandu)
            $sasaran = $posyandu->anaks->count();

            // K = Anak yang terdaftar di posyandu (same as S in this system)
            $terdaftar = $sasaran;

            // D = Ditimbang bulan ini
            $ditimbang = Kunjungan::where('posyandu_id', $posyandu->id)
                ->whereMonth('tanggal_kunjungan', $bulan)
                ->whereYear('tanggal_kunjungan', $tahun)
                ->distinct('anak_id')
                ->count('anak_id');

            // N = Berat badan naik
            $naikBb = Pengukuran::whereHas('kunjungan', function ($q) use ($posyandu, $bulan, $tahun) {
                $q->where('posyandu_id', $posyandu->id)
                  ->whereMonth('tanggal_kunjungan', $bulan)
                  ->whereYear('tanggal_kunjungan', $tahun);
            })->where('naik_berat_badan', true)->count();

            // Status counts
            $statusCounts = $this->getStatusCounts($posyandu->id, $bulan, $tahun);

            $data[] = [
                'posyandu' => $posyandu,
                's' => $sasaran,
                'k' => $terdaftar,
                'd' => $ditimbang,
                'n' => $naikBb,
                'd_per_s' => $sasaran > 0 ? round(($ditimbang / $sasaran) * 100, 1) : 0,
                'n_per_d' => $ditimbang > 0 ? round(($naikBb / $ditimbang) * 100, 1) : 0,
                'status' => $statusCounts,
            ];
        }

        // Total
        $total = [
            's' => collect($data)->sum('s'),
            'k' => collect($data)->sum('k'),
            'd' => collect($data)->sum('d'),
            'n' => collect($data)->sum('n'),
        ];
        $total['d_per_s'] = $total['s'] > 0 ? round(($total['d'] / $total['s']) * 100, 1) : 0;
        $total['n_per_d'] = $total['d'] > 0 ? round(($total['n'] / $total['d']) * 100, 1) : 0;

        return view('laporan.skdn', compact('data', 'total', 'bulan', 'tahun'));
    }

    /**
     * Peta Sebaran (Distribution Map)
     */
    public function sebaran(Request $request)
    {
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);

        $posyandus = Posyandu::all()->map(function ($posyandu) use ($bulan, $tahun) {
            $statusCounts = $this->getStatusCounts($posyandu->id, $bulan, $tahun);
            
            // Determine overall status color
            $stuntingRate = $statusCounts['total'] > 0 
                ? (($statusCounts['stunting']['pendek'] + $statusCounts['stunting']['sangat_pendek']) / $statusCounts['total']) * 100 
                : 0;

            $statusColor = 'success'; // Green - Normal
            if ($stuntingRate > 20) {
                $statusColor = 'danger'; // Red - High stunting
            } elseif ($stuntingRate > 10) {
                $statusColor = 'warning'; // Yellow - Moderate
            }

            return [
                'id' => $posyandu->id,
                'nama' => $posyandu->nama,
                'desa' => $posyandu->desa,
                'kecamatan' => $posyandu->kecamatan,
                'latitude' => $posyandu->latitude,
                'longitude' => $posyandu->longitude,
                'total_anak' => Anak::where('posyandu_id', $posyandu->id)->aktif()->balita()->count(),
                'kunjungan_bulan_ini' => Kunjungan::where('posyandu_id', $posyandu->id)
                    ->whereMonth('tanggal_kunjungan', $bulan)
                    ->whereYear('tanggal_kunjungan', $tahun)
                    ->count(),
                'status' => $statusCounts,
                'stunting_rate' => round($stuntingRate, 1),
                'status_color' => $statusColor,
            ];
        });

        // Summary statistics
        $summary = [
            'total_posyandu' => $posyandus->count(),
            'total_anak' => $posyandus->sum('total_anak'),
            'total_kunjungan' => $posyandus->sum('kunjungan_bulan_ini'),
            'posyandu_merah' => $posyandus->where('status_color', 'danger')->count(),
            'posyandu_kuning' => $posyandus->where('status_color', 'warning')->count(),
            'posyandu_hijau' => $posyandus->where('status_color', 'success')->count(),
        ];

        return view('laporan.sebaran', compact('posyandus', 'summary', 'bulan', 'tahun'));
    }

    /**
     * Export SKDN to Excel/CSV
     */
    public function exportSkdn(Request $request)
    {
        // TODO: Implement Excel export using Laravel Excel package
        return redirect()->route('laporan.skdn')
            ->with('info', 'Fitur export sedang dalam pengembangan.');
    }

    /**
     * Get status counts for a posyandu in a specific month
     */
    private function getStatusCounts($posyanduId, $bulan, $tahun): array
    {
        $pengukurans = Pengukuran::whereHas('kunjungan', function ($q) use ($posyanduId, $bulan, $tahun) {
            $q->where('posyandu_id', $posyanduId)
              ->whereMonth('tanggal_kunjungan', $bulan)
              ->whereYear('tanggal_kunjungan', $tahun);
        })->get();

        return [
            'total' => $pengukurans->count(),
            'gizi' => [
                'baik' => $pengukurans->where('status_gizi', 'gizi_baik')->count(),
                'kurang' => $pengukurans->where('status_gizi', 'gizi_kurang')->count(),
                'buruk' => $pengukurans->where('status_gizi', 'gizi_buruk')->count(),
                'lebih' => $pengukurans->where('status_gizi', 'gizi_lebih')->count(),
            ],
            'stunting' => [
                'normal' => $pengukurans->where('status_stunting', 'normal')->count(),
                'pendek' => $pengukurans->where('status_stunting', 'pendek')->count(),
                'sangat_pendek' => $pengukurans->where('status_stunting', 'sangat_pendek')->count(),
            ],
        ];
    }
}
