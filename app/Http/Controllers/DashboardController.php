<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\Kunjungan;
use App\Models\Pengukuran;
use App\Models\Posyandu;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        }

        return $this->kaderDashboard();
    }

    /**
     * Dashboard untuk Admin Puskesmas
     */
    private function adminDashboard()
    {
        // Get all posyandus with counts
        $posyandus = Posyandu::withCount(['anaks', 'kunjungans' => function ($query) {
            $query->whereMonth('tanggal_kunjungan', now()->month);
        }])->get();

        // Calculate stunting rate for each posyandu
        $posyandus = $posyandus->map(function ($posyandu) {
            $totalMeasurements = Pengukuran::whereHas('kunjungan', function ($q) use ($posyandu) {
                $q->where('posyandu_id', $posyandu->id)
                  ->whereMonth('tanggal_kunjungan', now()->month);
            })->count();
            
            $stuntingCases = Pengukuran::whereHas('kunjungan', function ($q) use ($posyandu) {
                $q->where('posyandu_id', $posyandu->id)
                  ->whereMonth('tanggal_kunjungan', now()->month);
            })->stunting()->count();
            
            $posyandu->stunting_rate = $totalMeasurements > 0 
                ? round(($stuntingCases / $totalMeasurements) * 100, 1) 
                : 0;
                
            return $posyandu;
        });

        // Total statistics
        $totalAnak = Anak::aktif()->balita()->count();
        $totalKunjunganBulanIni = Kunjungan::bulanIni()->count();
        $totalUsers = \App\Models\User::aktif()->count();

        // Get stunting statistics
        $stuntingCount = Pengukuran::whereHas('kunjungan', function ($q) {
            $q->whereMonth('tanggal_kunjungan', now()->month);
        })->stunting()->count();

        $underweightCount = Pengukuran::whereHas('kunjungan', function ($q) {
            $q->whereMonth('tanggal_kunjungan', now()->month);
        })->underweight()->count();

        // Status distribution this month
        $statusDistribution = $this->getStatusDistribution();

        // Stunting trend for last 6 months
        $stuntingTrend = $this->getStuntingTrend();

        // Recent visits
        $recentKunjungans = Kunjungan::with(['anak', 'user', 'pengukuran', 'posyandu'])
            ->latest('tanggal_kunjungan')
            ->take(10)
            ->get();

        // ALERTS: Children who need attention
        $alerts = [
            'belum_kunjungan' => Anak::aktif()->balita()
                ->whereDoesntHave('kunjungans', function ($q) {
                    $q->whereMonth('tanggal_kunjungan', now()->month)
                      ->whereYear('tanggal_kunjungan', now()->year);
                })
                ->with(['ibu', 'posyandu'])
                ->take(10)
                ->get(),
            'stunting' => Anak::aktif()->balita()
                ->whereHas('kunjungans.pengukuran', function ($q) {
                    $q->whereIn('status_stunting', ['pendek', 'sangat_pendek']);
                })
                ->with(['ibu', 'posyandu', 'kunjungans' => function ($q) {
                    $q->latest()->limit(1)->with('pengukuran');
                }])
                ->take(10)
                ->get(),
            'gizi_buruk' => Anak::aktif()->balita()
                ->whereHas('kunjungans.pengukuran', function ($q) {
                    $q->whereIn('status_gizi', ['gizi_kurang', 'gizi_buruk']);
                })
                ->with(['ibu', 'posyandu', 'kunjungans' => function ($q) {
                    $q->latest()->limit(1)->with('pengukuran');
                }])
                ->take(10)
                ->get(),
        ];

        return view('dashboard.admin', compact(
            'posyandus',
            'totalAnak',
            'totalKunjunganBulanIni',
            'totalUsers',
            'stuntingCount',
            'underweightCount',
            'statusDistribution',
            'stuntingTrend',
            'recentKunjungans',
            'alerts'
        ));
    }

    /**
     * Dashboard untuk Kader Posyandu
     */
    private function kaderDashboard()
    {
        $user = auth()->user();
        $posyandu = $user->posyandu;

        if (!$posyandu) {
            return view('dashboard.no-posyandu');
        }

        // Children in this posyandu
        $anaks = Anak::where('posyandu_id', $posyandu->id)
            ->aktif()
            ->balita()
            ->with(['ibu', 'pengukurans' => function ($q) {
                $q->latest()->limit(1);
            }])
            ->get();

        // Today's visits
        $kunjunganHariIni = Kunjungan::where('posyandu_id', $posyandu->id)
            ->hariIni()
            ->with(['anak', 'pengukuran'])
            ->get();

        // Children not yet visited this month
        $anakBelumKunjungan = $this->getAnakBelumKunjungan($posyandu->id);

        // Statistics for this posyandu
        $stats = [
            'total_anak' => $anaks->count(),
            'kunjungan_bulan_ini' => Kunjungan::where('posyandu_id', $posyandu->id)->bulanIni()->count(),
            'stunting' => 0,
            'gizi_kurang' => 0,
        ];

        // Count stunting and underweight from latest measurements
        foreach ($anaks as $anak) {
            $lastMeasurement = $anak->pengukuran_terakhir;
            if ($lastMeasurement) {
                if ($lastMeasurement->is_stunting) $stats['stunting']++;
                if ($lastMeasurement->is_underweight) $stats['gizi_kurang']++;
            }
        }

        return view('dashboard.kader', compact(
            'posyandu',
            'anaks',
            'kunjunganHariIni',
            'anakBelumKunjungan',
            'stats'
        ));
    }

    /**
     * Get list of children who haven't visited this month
     */
    private function getAnakBelumKunjungan($posyanduId)
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        return Anak::where('posyandu_id', $posyanduId)
            ->aktif()
            ->balita()
            ->whereDoesntHave('kunjungans', function ($query) use ($currentMonth, $currentYear) {
                $query->whereMonth('tanggal_kunjungan', $currentMonth)
                      ->whereYear('tanggal_kunjungan', $currentYear);
            })
            ->with('ibu')
            ->get();
    }

    /**
     * Get status distribution for admin dashboard
     */
    private function getStatusDistribution(): array
    {
        $currentMonth = now()->month;

        $pengukurans = Pengukuran::whereHas('kunjungan', function ($q) use ($currentMonth) {
            $q->whereMonth('tanggal_kunjungan', $currentMonth);
        })->get();

        return [
            'gizi_baik' => $pengukurans->where('status_gizi', 'gizi_baik')->count(),
            'gizi_kurang' => $pengukurans->where('status_gizi', 'gizi_kurang')->count(),
            'gizi_buruk' => $pengukurans->where('status_gizi', 'gizi_buruk')->count(),
            'gizi_lebih' => $pengukurans->where('status_gizi', 'gizi_lebih')->count(),
            'stunting' => $pengukurans->whereIn('status_stunting', ['pendek', 'sangat_pendek'])->count(),
            'normal' => $pengukurans->where('status_stunting', 'normal')->count(),
        ];
    }

    /**
     * Get stunting trend for last 6 months
     */
    private function getStuntingTrend(): array
    {
        $trend = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $month = $date->month;
            $year = $date->year;
            
            $pengukurans = Pengukuran::whereHas('kunjungan', function ($q) use ($month, $year) {
                $q->whereMonth('tanggal_kunjungan', $month)
                  ->whereYear('tanggal_kunjungan', $year);
            })->get();
            
            $total = $pengukurans->count();
            $stunting = $pengukurans->whereIn('status_stunting', ['pendek', 'sangat_pendek'])->count();
            $giziBuruk = $pengukurans->whereIn('status_gizi', ['gizi_kurang', 'gizi_buruk'])->count();
            
            $trend[] = [
                'month' => $date->translatedFormat('M Y'),
                'label' => $date->translatedFormat('M'),
                'total' => $total,
                'stunting' => $stunting,
                'stunting_rate' => $total > 0 ? round(($stunting / $total) * 100, 1) : 0,
                'gizi_buruk' => $giziBuruk,
                'gizi_buruk_rate' => $total > 0 ? round(($giziBuruk / $total) * 100, 1) : 0,
            ];
        }
        
        return $trend;
    }
}
