<?php

namespace App\Services;

use Carbon\Carbon;

/**
 * GrowthCalculatorService - "Otak LENTERA"
 * 
 * Service untuk menghitung status gizi anak berdasarkan standar WHO.
 * Menggunakan rumus estimasi Z-Score berdasarkan data referensi WHO Anthro.
 */
class GrowthCalculatorService
{
    /**
     * WHO Reference Data (Simplified Median & SD values)
     * Data ini adalah estimasi berdasarkan WHO Child Growth Standards
     * 
     * Format: [age_months => [median, sd]]
     */
    
    // Weight-for-Age (BB/U) untuk Laki-laki (0-60 bulan)
    private const WFA_BOYS = [
        0 => [3.3, 0.47], 1 => [4.5, 0.54], 2 => [5.6, 0.61], 3 => [6.4, 0.67],
        4 => [7.0, 0.72], 5 => [7.5, 0.76], 6 => [7.9, 0.80], 7 => [8.3, 0.83],
        8 => [8.6, 0.86], 9 => [8.9, 0.89], 10 => [9.2, 0.92], 11 => [9.4, 0.94],
        12 => [9.6, 0.97], 15 => [10.3, 1.04], 18 => [10.9, 1.11], 21 => [11.5, 1.18],
        24 => [12.0, 1.24], 30 => [13.3, 1.38], 36 => [14.3, 1.52], 42 => [15.3, 1.66],
        48 => [16.3, 1.80], 54 => [17.3, 1.94], 60 => [18.3, 2.08],
    ];

    // Weight-for-Age (BB/U) untuk Perempuan (0-60 bulan)
    private const WFA_GIRLS = [
        0 => [3.2, 0.44], 1 => [4.2, 0.51], 2 => [5.1, 0.58], 3 => [5.8, 0.64],
        4 => [6.4, 0.69], 5 => [6.9, 0.74], 6 => [7.3, 0.78], 7 => [7.6, 0.82],
        8 => [7.9, 0.85], 9 => [8.2, 0.88], 10 => [8.5, 0.91], 11 => [8.7, 0.94],
        12 => [8.9, 0.96], 15 => [9.6, 1.04], 18 => [10.2, 1.11], 21 => [10.9, 1.18],
        24 => [11.5, 1.25], 30 => [12.7, 1.39], 36 => [13.9, 1.53], 42 => [15.0, 1.68],
        48 => [16.1, 1.82], 54 => [17.2, 1.97], 60 => [18.2, 2.12],
    ];

    // Height-for-Age (TB/U) untuk Laki-laki (0-60 bulan)
    private const HFA_BOYS = [
        0 => [49.9, 1.89], 1 => [54.7, 2.00], 2 => [58.4, 2.10], 3 => [61.4, 2.17],
        4 => [63.9, 2.23], 5 => [65.9, 2.28], 6 => [67.6, 2.33], 7 => [69.2, 2.37],
        8 => [70.6, 2.41], 9 => [72.0, 2.45], 10 => [73.3, 2.49], 11 => [74.5, 2.52],
        12 => [75.7, 2.56], 15 => [79.1, 2.67], 18 => [82.3, 2.78], 21 => [85.1, 2.89],
        24 => [87.8, 3.00], 30 => [92.4, 3.23], 36 => [96.1, 3.45], 42 => [99.9, 3.68],
        48 => [103.3, 3.90], 54 => [106.7, 4.13], 60 => [110.0, 4.35],
    ];

    // Height-for-Age (TB/U) untuk Perempuan (0-60 bulan)
    private const HFA_GIRLS = [
        0 => [49.1, 1.86], 1 => [53.7, 1.96], 2 => [57.1, 2.05], 3 => [59.8, 2.13],
        4 => [62.1, 2.19], 5 => [64.0, 2.25], 6 => [65.7, 2.30], 7 => [67.3, 2.35],
        8 => [68.7, 2.39], 9 => [70.1, 2.43], 10 => [71.5, 2.47], 11 => [72.8, 2.51],
        12 => [74.0, 2.54], 15 => [77.5, 2.66], 18 => [80.7, 2.78], 21 => [83.7, 2.90],
        24 => [86.4, 3.02], 30 => [91.2, 3.27], 36 => [95.1, 3.51], 42 => [98.9, 3.76],
        48 => [102.7, 4.01], 54 => [106.2, 4.26], 60 => [109.4, 4.51],
    ];

    // Weight-for-Height references (simplified - height ranges)
    private const WFH_BOYS = [
        45 => [2.4, 0.26], 50 => [3.2, 0.34], 55 => [4.2, 0.42], 60 => [5.5, 0.52],
        65 => [6.8, 0.62], 70 => [8.0, 0.74], 75 => [9.2, 0.86], 80 => [10.4, 0.98],
        85 => [11.7, 1.12], 90 => [13.0, 1.26], 95 => [14.4, 1.42], 100 => [15.8, 1.58],
        105 => [17.4, 1.76], 110 => [19.1, 1.96],
    ];

    private const WFH_GIRLS = [
        45 => [2.5, 0.27], 50 => [3.2, 0.34], 55 => [4.1, 0.41], 60 => [5.4, 0.51],
        65 => [6.6, 0.60], 70 => [7.8, 0.71], 75 => [8.9, 0.82], 80 => [10.1, 0.95],
        85 => [11.4, 1.08], 90 => [12.8, 1.23], 95 => [14.2, 1.39], 100 => [15.8, 1.57],
        105 => [17.5, 1.77], 110 => [19.4, 1.99],
    ];

    /**
     * Hitung usia dalam bulan dari tanggal lahir
     */
    public function calculateAgeInMonths(Carbon $birthDate, ?Carbon $measurementDate = null): int
    {
        $measurementDate = $measurementDate ?? Carbon::now();
        return $birthDate->diffInMonths($measurementDate);
    }

    /**
     * Hitung usia dalam hari (lebih presisi)
     */
    public function calculateAgeInDays(Carbon $birthDate, ?Carbon $measurementDate = null): int
    {
        $measurementDate = $measurementDate ?? Carbon::now();
        return $birthDate->diffInDays($measurementDate);
    }

    /**
     * Hitung semua Z-Scores
     * 
     * @param int $ageMonths Usia dalam bulan
     * @param string $gender 'L' untuk laki-laki, 'P' untuk perempuan
     * @param float $weight Berat badan dalam kg
     * @param float $height Tinggi badan dalam cm
     * @return array ['bb_u' => float, 'tb_u' => float, 'bb_tb' => float]
     */
    public function calculateZScores(int $ageMonths, string $gender, float $weight, float $height): array
    {
        $isBoy = strtoupper($gender) === 'L';
        
        return [
            'bb_u' => $this->calculateWeightForAge($ageMonths, $weight, $isBoy),
            'tb_u' => $this->calculateHeightForAge($ageMonths, $height, $isBoy),
            'bb_tb' => $this->calculateWeightForHeight($height, $weight, $isBoy),
        ];
    }

    /**
     * Hitung Z-Score BB/U (Weight-for-Age)
     */
    public function calculateWeightForAge(int $ageMonths, float $weight, bool $isBoy): float
    {
        $reference = $isBoy ? self::WFA_BOYS : self::WFA_GIRLS;
        [$median, $sd] = $this->getInterpolatedReference($reference, $ageMonths);
        
        return round(($weight - $median) / $sd, 2);
    }

    /**
     * Hitung Z-Score TB/U (Height-for-Age)
     */
    public function calculateHeightForAge(int $ageMonths, float $height, bool $isBoy): float
    {
        $reference = $isBoy ? self::HFA_BOYS : self::HFA_GIRLS;
        [$median, $sd] = $this->getInterpolatedReference($reference, $ageMonths);
        
        return round(($height - $median) / $sd, 2);
    }

    /**
     * Hitung Z-Score BB/TB (Weight-for-Height)
     */
    public function calculateWeightForHeight(float $height, float $weight, bool $isBoy): float
    {
        $reference = $isBoy ? self::WFH_BOYS : self::WFH_GIRLS;
        [$median, $sd] = $this->getInterpolatedReference($reference, (int)$height);
        
        return round(($weight - $median) / $sd, 2);
    }

    /**
     * Interpolasi nilai referensi untuk usia/tinggi yang tidak ada di tabel
     */
    private function getInterpolatedReference(array $reference, int $value): array
    {
        // Jika nilai ada di tabel, langsung kembalikan
        if (isset($reference[$value])) {
            return $reference[$value];
        }

        // Cari nilai terdekat untuk interpolasi
        $keys = array_keys($reference);
        sort($keys);

        $lower = null;
        $upper = null;

        foreach ($keys as $key) {
            if ($key < $value) {
                $lower = $key;
            } elseif ($key > $value && $upper === null) {
                $upper = $key;
                break;
            }
        }

        // Edge cases
        if ($lower === null) {
            return $reference[$keys[0]];
        }
        if ($upper === null) {
            return $reference[$keys[count($keys) - 1]];
        }

        // Linear interpolation
        $ratio = ($value - $lower) / ($upper - $lower);
        $medianLower = $reference[$lower][0];
        $medianUpper = $reference[$upper][0];
        $sdLower = $reference[$lower][1];
        $sdUpper = $reference[$upper][1];

        return [
            $medianLower + $ratio * ($medianUpper - $medianLower),
            $sdLower + $ratio * ($sdUpper - $sdLower),
        ];
    }

    /**
     * Tentukan status gizi berdasarkan Z-Scores
     * 
     * @param array $zScores Array dari calculateZScores()
     * @return array ['status_gizi' => string, 'status_stunting' => string, 'status_wasting' => string]
     */
    public function determineNutritionalStatus(array $zScores): array
    {
        return [
            'status_gizi' => $this->determineStatusGizi($zScores['bb_u']),
            'status_stunting' => $this->determineStatusStunting($zScores['tb_u']),
            'status_wasting' => $this->determineStatusWasting($zScores['bb_tb']),
        ];
    }

    /**
     * Tentukan status gizi (BB/U)
     * Berdasarkan Permenkes RI tentang Standar Antropometri Anak
     */
    private function determineStatusGizi(float $zScore): string
    {
        if ($zScore < -3) {
            return 'gizi_buruk';       // Severely underweight
        } elseif ($zScore < -2) {
            return 'gizi_kurang';      // Underweight
        } elseif ($zScore <= 2) {
            return 'gizi_baik';        // Normal
        } else {
            return 'gizi_lebih';       // Overweight
        }
    }

    /**
     * Tentukan status stunting (TB/U)
     */
    private function determineStatusStunting(float $zScore): string
    {
        if ($zScore < -3) {
            return 'sangat_pendek';    // Severely stunted
        } elseif ($zScore < -2) {
            return 'pendek';           // Stunted
        } elseif ($zScore <= 2) {
            return 'normal';           // Normal
        } else {
            return 'tinggi';           // Tall
        }
    }

    /**
     * Tentukan status wasting (BB/TB)
     */
    private function determineStatusWasting(float $zScore): string
    {
        if ($zScore < -3) {
            return 'gizi_buruk_akut';  // Severe wasting
        } elseif ($zScore < -2) {
            return 'gizi_kurang_akut'; // Wasting
        } elseif ($zScore <= 2) {
            return 'normal';           // Normal
        } elseif ($zScore <= 3) {
            return 'berisiko_lebih';   // Overweight risk
        } else {
            return 'obesitas';         // Obese
        }
    }

    /**
     * Hitung lengkap dan kembalikan hasil analisis
     */
    public function analyze(Carbon $birthDate, string $gender, float $weight, float $height, ?Carbon $measurementDate = null): array
    {
        $ageMonths = $this->calculateAgeInMonths($birthDate, $measurementDate);
        $ageDays = $this->calculateAgeInDays($birthDate, $measurementDate);
        $zScores = $this->calculateZScores($ageMonths, $gender, $weight, $height);
        $status = $this->determineNutritionalStatus($zScores);

        return [
            'usia_bulan' => $ageMonths,
            'usia_hari' => $ageDays,
            'zscore_bb_u' => $zScores['bb_u'],
            'zscore_tb_u' => $zScores['tb_u'],
            'zscore_bb_tb' => $zScores['bb_tb'],
            'status_gizi' => $status['status_gizi'],
            'status_stunting' => $status['status_stunting'],
            'status_wasting' => $status['status_wasting'],
            'is_stunting' => in_array($status['status_stunting'], ['sangat_pendek', 'pendek']),
            'is_underweight' => in_array($status['status_gizi'], ['gizi_buruk', 'gizi_kurang']),
            'is_wasting' => in_array($status['status_wasting'], ['gizi_buruk_akut', 'gizi_kurang_akut']),
        ];
    }

    /**
     * Format hasil analisis untuk ditampilkan ke user
     */
    public function formatAnalysisResult(array $analysis): array
    {
        $statusLabels = [
            'gizi_buruk' => ['label' => 'Gizi Buruk', 'color' => 'danger', 'icon' => 'bx-error-circle'],
            'gizi_kurang' => ['label' => 'Gizi Kurang', 'color' => 'warning', 'icon' => 'bx-error'],
            'gizi_baik' => ['label' => 'Gizi Baik', 'color' => 'success', 'icon' => 'bx-check-circle'],
            'gizi_lebih' => ['label' => 'Gizi Lebih', 'color' => 'info', 'icon' => 'bx-info-circle'],
            'sangat_pendek' => ['label' => 'Sangat Pendek (Stunting Berat)', 'color' => 'danger', 'icon' => 'bx-error-circle'],
            'pendek' => ['label' => 'Pendek (Stunting)', 'color' => 'warning', 'icon' => 'bx-error'],
            'normal' => ['label' => 'Normal', 'color' => 'success', 'icon' => 'bx-check-circle'],
            'tinggi' => ['label' => 'Tinggi', 'color' => 'info', 'icon' => 'bx-up-arrow-alt'],
            'gizi_buruk_akut' => ['label' => 'Gizi Buruk Akut (Wasting Berat)', 'color' => 'danger', 'icon' => 'bx-error-circle'],
            'gizi_kurang_akut' => ['label' => 'Gizi Kurang Akut (Wasting)', 'color' => 'warning', 'icon' => 'bx-error'],
            'berisiko_lebih' => ['label' => 'Berisiko Gizi Lebih', 'color' => 'info', 'icon' => 'bx-info-circle'],
            'obesitas' => ['label' => 'Obesitas', 'color' => 'info', 'icon' => 'bx-error'],
        ];

        return [
            'usia' => $this->formatUsia($analysis['usia_bulan']),
            'status_gizi' => $statusLabels[$analysis['status_gizi']] ?? null,
            'status_stunting' => $statusLabels[$analysis['status_stunting']] ?? null,
            'status_wasting' => $statusLabels[$analysis['status_wasting']] ?? null,
            'zscore_bb_u' => $analysis['zscore_bb_u'],
            'zscore_tb_u' => $analysis['zscore_tb_u'],
            'zscore_bb_tb' => $analysis['zscore_bb_tb'],
            'needs_intervention' => $analysis['is_stunting'] || $analysis['is_underweight'] || $analysis['is_wasting'],
            'alert_level' => $this->determineAlertLevel($analysis),
        ];
    }

    /**
     * Format usia dalam format yang mudah dibaca
     */
    private function formatUsia(int $usiaBulan): string
    {
        $tahun = intdiv($usiaBulan, 12);
        $bulan = $usiaBulan % 12;

        if ($tahun > 0) {
            return "{$tahun} tahun {$bulan} bulan";
        }
        return "{$bulan} bulan";
    }

    /**
     * Tentukan level peringatan untuk dashboard
     */
    private function determineAlertLevel(array $analysis): string
    {
        // Check for severe conditions
        if ($analysis['status_gizi'] === 'gizi_buruk' || 
            $analysis['status_stunting'] === 'sangat_pendek' ||
            $analysis['status_wasting'] === 'gizi_buruk_akut') {
            return 'critical'; // Merah - perlu rujukan segera
        }

        // Check for moderate conditions
        if ($analysis['is_stunting'] || $analysis['is_underweight'] || $analysis['is_wasting']) {
            return 'warning'; // Kuning - perlu intervensi
        }

        return 'normal'; // Hijau - baik
    }
}
