<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header-table td {
            vertical-align: middle;
        }
        .header-logo {
            width: 80px;
        }
        .header-text {
            text-align: center;
        }
        .header-text h1 {
            margin: 0;
            font-size: 24px;
            color: #111;
        }
        .header-text p {
            margin: 2px 0;
            font-size: 12px;
        }
        .report-title {
            text-align: center;
            margin-bottom: 20px;
        }
        .report-title h2 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .report-title p {
            margin: 5px 0 0;
            font-size: 12px;
            color: #555;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .data-table th, .data-table td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }
        .data-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .text-right {
            text-align: right !important;
        }
        .text-center {
            text-align: center !important;
        }
        .signature-block {
            width: 300px;
            float: right;
            text-align: center;
            margin-top: 50px;
        }
        .signature-name {
            margin-top: 80px;
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- Kop Surat -->
    <table class="header-table">
        <tr>
            <td width="20%">
                <img src="{{ public_path('Resource/xyra_logo.png') }}" class="header-logo" alt="Logo">
            </td>
            <td width="60%" class="header-text">
                <h1>XYRA.ID</h1>
                <p>Cloth Management System & Retail</p>
                <p>Jl. Contoh Perusahaan No. 123, Kota Bandung, Jawa Barat</p>
                <p>Telp: (022) 1234567 | Email: info@xyra.id | Web: www.xyra.id</p>
            </td>
            <td width="20%"></td>
        </tr>
    </table>

    <!-- Judul Laporan -->
    <div class="report-title">
        <h2>{{ $title }}</h2>
        <p>{{ $period }}</p>
    </div>

    <!-- Data Table -->
    <table class="data-table">
        <thead>
            <tr>
                @foreach($headers as $header)
                    <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($data as $row)
                <tr>
                    @foreach($row as $cell)
                        <td>{{ $cell }}</td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($headers) }}" class="text-center">Data tidak tersedia untuk periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pengesahan -->
    <div class="signature-block">
        <p>Bandung, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <p style="margin-bottom: 80px;">Pimpinan / Manager</p>
        <p class="signature-name">_______________________</p>
    </div>

</body>
</html>