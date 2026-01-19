<?php

namespace App\Exports;

use App\Models\Ibu;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class IbuExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $posyanduId;
    protected $rowNumber = 0;

    public function __construct($posyanduId = null)
    {
        $this->posyanduId = $posyanduId;
    }

    public function collection()
    {
        $query = Ibu::with(['posyandu', 'anaks'])
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
            'Nama Ibu',
            'NIK',
            'Tanggal Lahir',
            'Usia',
            'Alamat',
            'No. Telepon',
            'Posyandu',
            'Jumlah Anak',
        ];
    }

    public function map($ibu): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,
            $ibu->nama ?? '-',
            $ibu->nik ?? '-',
            $ibu->tanggal_lahir ? $ibu->tanggal_lahir->format('d/m/Y') : '-',
            $ibu->usia ?? '-',
            $ibu->alamat ?? '-',
            $ibu->telepon ?? '-',
            $ibu->posyandu?->nama ?? '-',
            $ibu->anaks?->count() ?? 0,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E91E8C']
                ]
            ],
        ];
    }
}
