<?php

namespace App\Exports;

use App\Models\Anak;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AnakExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $posyanduId;
    protected $rowNumber = 0;

    public function __construct($posyanduId = null)
    {
        $this->posyanduId = $posyanduId;
    }

    public function collection()
    {
        $query = Anak::with(['ibu', 'posyandu', 'kunjungans.pengukuran'])
            ->where('aktif', true);

        if ($this->posyanduId) {
            $query->where('posyandu_id', $this->posyanduId);
        }

        return $query->orderBy('nama')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Anak',
            'NIK',
            'Jenis Kelamin',
            'Tanggal Lahir',
            'Usia',
            'Nama Ibu',
            'Posyandu',
            'BB Lahir (kg)',
            'PB Lahir (cm)',
            'BB Terakhir (kg)',
            'TB Terakhir (cm)',
            'Status Gizi',
            'Status Stunting',
        ];
    }

    public function map($anak): array
    {
        $this->rowNumber++;

        // Get latest measurement using accessor
        $pengukuran = $anak->pengukuran_terakhir;

        return [
            $this->rowNumber,
            $anak->nama ?? '-',
            $anak->nik ?? '-',
            $anak->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
            $anak->tanggal_lahir ? $anak->tanggal_lahir->format('d/m/Y') : '-',
            $anak->usia_format ?? '-',
            $anak->ibu?->nama ?? '-',
            $anak->posyandu?->nama ?? '-',
            $anak->berat_lahir ?? '-',
            $anak->panjang_lahir ?? '-',
            $pengukuran?->berat_badan ?? '-',
            $pengukuran?->tinggi_badan ?? '-',
            $pengukuran?->status_gizi ?? '-',
            $pengukuran?->status_stunting ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4A90D9']
                ]
            ],
        ];
    }
}
