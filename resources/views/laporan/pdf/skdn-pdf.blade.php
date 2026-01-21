<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan SKDN - {{ $periode }}</title>
    <style>
        @page {
            margin: 20mm 15mm;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10pt;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 16pt;
        }
        .header p {
            margin: 3px 0;
            font-size: 9pt;
        }
        .kop {
            text-align: center;
            padding-bottom: 15px;
            margin-bottom: 10px;
            border-bottom: 2px solid #000;
        }
        .kop table {
            width: 100%;
            margin: 0;
            border: none;
        }
        .kop table td {
            border: none;
            padding: 0;
            vertical-align: middle;
        }
        .logo {
            width: 70px;
            height: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th {
            background-color: #4CAF50;
            color: white;
            padding: 8px 5px;
            text-align: center;
            font-size: 9pt;
            border: 1px solid #333;
        }
        td {
            padding: 6px 5px;
            border: 1px solid #ddd;
            font-size: 9pt;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .fw-bold {
            font-weight: bold;
        }
        .total-row {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .footer-signatures {
            margin-top: 40px;
            page-break-inside: avoid;
        }
        .signature-box {
            width: 45%;
            display: inline-block;
            vertical-align: top;
        }
        .signature-box.right {
            float: right;
        }
        .keterangan {
            margin: 15px 0;
            padding: 10px;
            background: #f9f9f9;
            border-left: 4px solid #4CAF50;
            font-size: 9pt;
        }
        .keterangan strong {
            display: block;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    {{-- Header/Kop Surat --}}
    <div class="kop">
        <table>
            <tr>
                <td style="width: 15%; text-align: left;">
                    <img src="{{ public_path('assets/img/favicon/logo.png') }}" class="logo" alt="Logo">
                </td>
                <td style="width: 70%; text-align: center;">
                    <div style="font-size: 14pt; font-weight: bold; margin-bottom: 2px;">PUSKESMAS [NAMA PUSKESMAS]</div>
                    <div style="font-size: 10pt; margin-bottom: 2px;">LAPORAN SKDN (S-K-D-N)</div>
                    <div style="font-size: 9pt;">Jl. [Alamat Puskesmas]</div>
                </td>
                <td style="width: 15%;"></td>
            </tr>
        </table>
    </div>

    <div class="header">
        <h2>LAPORAN SKDN</h2>
        <p>Periode: {{ $periode }}</p>
    </div>

    {{-- Keterangan --}}
    <div class="keterangan">
        <strong>Keterangan:</strong>
        <strong>S</strong> = Sasaran (Jumlah Balita) |
        <strong>K</strong> = Terdaftar/Punya KMS |
        <strong>D</strong> = Ditimbang Bulan Ini |
        <strong>N</strong> = Naik Berat Badan |
        <strong>D/S</strong> = Persentase Cakupan Penimbangan |
        <strong>N/D</strong> = Persentase Kenaikan BB
    </div>

    {{-- Data Table --}}
    <table>
        <thead>
            <tr>
                <th rowspan="2" style="width: 5%;">No</th>
                <th rowspan="2" style="width: 25%;">Posyandu</th>
                <th colspan="4">Jumlah</th>
                <th colspan="2">Persentase</th>
                <th colspan="4">Status Gizi</th>
            </tr>
            <tr>
                <th style="width: 6%;">S</th>
                <th style="width: 6%;">K</th>
                <th style="width: 6%;">D</th>
                <th style="width: 6%;">N</th>
                <th style="width: 7%;">D/S %</th>
                <th style="width: 7%;">N/D %</th>
                <th style="width: 7%;">Baik</th>
                <th style="width: 7%;">Kurang</th>
                <th style="width: 7%;">Buruk</th>
                <th style="width: 7%;">Lebih</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $row)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $row['posyandu']->nama }}</td>
                <td class="text-center">{{ $row['s'] }}</td>
                <td class="text-center">{{ $row['k'] }}</td>
                <td class="text-center">{{ $row['d'] }}</td>
                <td class="text-center">{{ $row['n'] }}</td>
                <td class="text-center">{{ $row['d_per_s'] }}%</td>
                <td class="text-center">{{ $row['n_per_d'] }}%</td>
                <td class="text-center">{{ $row['status']['gizi']['baik'] }}</td>
                <td class="text-center">{{ $row['status']['gizi']['kurang'] }}</td>
                <td class="text-center">{{ $row['status']['gizi']['buruk'] }}</td>
                <td class="text-center">{{ $row['status']['gizi']['lebih'] }}</td>
            </tr>
            @endforeach
            
            {{-- Total Row --}}
            <tr class="total-row">
                <td colspan="2" class="text-center fw-bold">TOTAL</td>
                <td class="text-center fw-bold">{{ $total['s'] }}</td>
                <td class="text-center fw-bold">{{ $total['k'] }}</td>
                <td class="text-center fw-bold">{{ $total['d'] }}</td>
                <td class="text-center fw-bold">{{ $total['n'] }}</td>
                <td class="text-center fw-bold">{{ $total['d_per_s'] }}%</td>
                <td class="text-center fw-bold">{{ $total['n_per_d'] }}%</td>
                <td colspan="4" class="text-center">-</td>
            </tr>
        </tbody>
    </table>

    {{-- Footer Signatures --}}
    <div class="footer-signatures">
        <div class="signature-box">
            <div style="text-align: center;">
                <p style="margin: 0;">Mengetahui,</p>
                <p style="margin: 0; font-weight: bold;">Kepala Puskesmas</p>
                <br><br><br>
                <p style="margin: 0; text-decoration: underline; font-weight: bold;">(...................................)</p>
                <p style="margin: 0; font-size: 8pt;">NIP. </p>
            </div>
        </div>

        <div class="signature-box right">
            <div style="text-align: center;">
                <p style="margin: 0;">[Nama Daerah], {{ now()->translatedFormat('d F Y') }}</p>
                <p style="margin: 0; font-weight: bold;">Penanggung Jawab Gizi</p>
                <br><br><br>
                <p style="margin: 0; text-decoration: underline; font-weight: bold;">(...................................)</p>
                <p style="margin: 0; font-size: 8pt;">NIP. </p>
            </div>
        </div>
    </div>
</body>
</html>
