<?php

namespace App\Http\Controllers;

use App\Exports\AnakExport;
use App\Exports\IbuExport;
use App\Exports\KunjunganExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    /**
     * Export data anak to Excel
     */
    public function anak(Request $request)
    {
        $posyanduId = auth()->user()->isKader() 
            ? auth()->user()->posyandu_id 
            : $request->posyandu_id;

        $filename = 'Data_Anak_' . date('Y-m-d_His') . '.xlsx';

        return Excel::download(new AnakExport($posyanduId), $filename);
    }

    /**
     * Export data ibu to Excel
     */
    public function ibu(Request $request)
    {
        $posyanduId = auth()->user()->isKader() 
            ? auth()->user()->posyandu_id 
            : $request->posyandu_id;

        $filename = 'Data_Ibu_' . date('Y-m-d_His') . '.xlsx';

        return Excel::download(new IbuExport($posyanduId), $filename);
    }

    /**
     * Export data kunjungan to Excel
     */
    public function kunjungan(Request $request)
    {
        $posyanduId = auth()->user()->isKader() 
            ? auth()->user()->posyandu_id 
            : $request->posyandu_id;

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $filename = 'Laporan_Kunjungan_' . date('Y-m-d_His') . '.xlsx';

        return Excel::download(new KunjunganExport($posyanduId, $startDate, $endDate), $filename);
    }
}
