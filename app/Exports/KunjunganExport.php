<?php

namespace App\Exports;

use App\Models\Kunjungan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KunjunganExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $posyanduId;
    protected $startDate;
    protected $endDate;
    protected $rowNumber = 0;

    public function __construct($posyanduId = null, $startDate = null, $endDate = null)
    {
        $this->posyanduId = $posyanduId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = Kunjungan::with(['anak.ibu', 'anak.posyandu', 'pengukuran', 'pelayanan', 'user']);

        if ($this->posyanduId) {
            $query->whereHas('anak', function ($q) {
                $q->where('posyandu_id', $this->posyanduId);
            });
        }

        if ($this->startDate) {
            $query->whereDate('tanggal_kunjungan', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->whereDate('tanggal_kunjungan', '<=', $this->endDate);
        }

        return $query->orderByDesc('tanggal_kunjungan')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal Kunjungan',
            'Nama Anak',
            'Jenis Kelamin',
            'Usia (bulan)',
            'Nama Ibu',
            'Posyandu',
            'BB (kg)',
            'TB (cm)',
            'LK (cm)',
            'LILA (cm)',
            'Status Gizi',
            'Status Stunting',
            'Vitamin A',
            'Obat Cacing',
            'PMT',
            'Imunisasi',
            'Petugas',
        ];
    }

    public function map($kunjungan): array
    {
        $this->rowNumber++;

        $pengukuran = $kunjungan->pengukuran;
        $pelayanan = $kunjungan->pelayanan;

        return [
            $this->rowNumber,
            $kunjungan->tanggal_kunjungan ? $kunjungan->tanggal_kunjungan->format('d/m/Y') : '-',
            $kunjungan->anak?->nama ?? '-',
            $kunjungan->anak?->jenis_kelamin == 'L' ? 'L' : 'P',
            $kunjungan->usia_bulan ?? '-',
            $kunjungan->anak?->ibu?->nama ?? '-',
            $kunjungan->anak?->posyandu?->nama ?? '-',
            $pengukuran?->berat_badan ?? '-',
            $pengukuran?->tinggi_badan ?? '-',
            $pengukuran?->lingkar_kepala ?? '-',
            $pengukuran?->lingkar_lengan ?? '-',
            $pengukuran?->status_gizi ?? '-',
            $pengukuran?->status_stunting ?? '-',
            $pelayanan?->vitamin_a ? 'Ya' : 'Tidak',
            $pelayanan?->obat_cacing ? 'Ya' : 'Tidak',
            $pelayanan?->pmt ? 'Ya' : 'Tidak',
            ($pelayanan?->imunisasi && is_array($pelayanan->imunisasi)) ? implode(', ', $pelayanan->imunisasi) : '-',
            $kunjungan->user?->name ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '28C76F']
                ]
            ],
        ];
    }
}
