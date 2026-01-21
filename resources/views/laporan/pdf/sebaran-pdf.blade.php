<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Peta Sebaran Status Gizi - {{ $periode }}</title>
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
        .summary-cards {
            margin: 20px 0;
            display: table;
            width: 100%;
        }
        .summary-card {
            display: table-cell;
            width: 25%;
            padding: 10px;
            text-align: center;
            border: 2px solid #ddd;
            background: #f9f9f9;
        }
        .summary-card.primary { border-color: #007bff; background: #e7f3ff; }
        .summary-card.info { border-color: #17a2b8; background: #d6f5f9; }
        .summary-card.success { border-color: #28a745; background: #d4edda; }
        .summary-card.danger { border-color: #dc3545; background: #f8d7da; }
        .summary-card h3 {
            margin: 5px 0;
            font-size: 18pt;
        }
        .summary-card small {
            font-size: 8pt;
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
        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 8pt;
        }
        .badge-success { background: #28a745; color: white; }
        .badge-warning { background: #ffc107; color: #000; }
        .badge-danger { background: #dc3545; color: white; }
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
                    <div style="font-size: 10pt; margin-bottom: 2px;">PETA SEBARAN STATUS GIZI & STUNTING</div>
                    <div style="font-size: 9pt;">Jl. [Alamat Puskesmas]</div>
                </td>
                <td style="width: 15%;"></td>
            </tr>
        </table>
    </div>

    <div class="header">
        <h2>PETA SEBARAN STATUS GIZI</h2>
        <p>Periode: {{ $periode }}</p>
    </div>

    {{-- Summary Cards --}}
    <div class="summary-cards">
        <div class="summary-card primary">
            <h3>{{ $summary['total_posyandu'] }}</h3>
            <small>Posyandu</small>
        </div>
        <div class="summary-card info">
            <h3>{{ $summary['total_anak'] }}</h3>
            <small>Total Balita</small>
        </div>
        <div class="summary-card success">
            <h3>{{ $summary['posyandu_hijau'] }}</h3>
            <small>Posyandu Hijau</small>
        </div>
        <div class="summary-card danger">
            <h3>{{ $summary['posyandu_merah'] }}</h3>
            <small>Posyandu Merah</small>
        </div>
    </div>

    {{-- Data Table --}}
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 22%;">Posyandu</th>
                <th style="width: 15%;">Desa</th>
                <th style="width: 8%;">Total Balita</th>
                <th style="width: 10%;">Ditimbang</th>
                <th style="width: 10%;">Rate Stunting</th>
                <th style="width: 10%;">Status</th>
                <th colspan="3" style="width: 20%;">Status Gizi</th>
            </tr>
            <tr>
                <th colspan="7"></th>
                <th style="width: 7%;">Baik</th>
                <th style="width: 7%;">Kurang</th>
                <th style="width: 6%;">Buruk</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posyandus as $index => $posyandu)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $posyandu['nama'] }}</td>
                <td>{{ $posyandu['desa'] }}</td>
                <td class="text-center">{{ $posyandu['total_anak'] }}</td>
                <td class="text-center">{{ $posyandu['kunjungan_bulan_ini'] }}</td>
                <td class="text-center">{{ $posyandu['stunting_rate'] }}%</td>
                <td class="text-center">
                    <span class="badge badge-{{ $posyandu['status_color'] }}">
                        @if($posyandu['status_color'] == 'success')
                            HIJAU
                        @elseif($posyandu['status_color'] == 'warning')
                            KUNING
                        @else
                            MERAH
                        @endif
                    </span>
                </td>
                <td class="text-center">{{ $posyandu['status']['gizi']['baik'] }}</td>
                <td class="text-center">{{ $posyandu['status']['gizi']['kurang'] }}</td>
                <td class="text-center">{{ $posyandu['status']['gizi']['buruk'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Legend --}}
    <div style="margin: 15px 0; padding: 10px; background: #f9f9f9; border-left: 4px solid #4CAF50; font-size: 9pt;">
        <strong>Keterangan Status:</strong><br>
        <span class="badge badge-success">HIJAU</span> = Rate Stunting < 10% (Normal)<br>
        <span class="badge badge-warning">KUNING</span> = Rate Stunting 10-20% (Waspada)<br>
        <span class="badge badge-danger">MERAH</span> = Rate Stunting > 20% (Tinggi)
    </div>

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
