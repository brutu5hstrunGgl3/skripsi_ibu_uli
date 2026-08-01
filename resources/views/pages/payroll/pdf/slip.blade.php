<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #222;
            background: #fff;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 24px;
            box-sizing: border-box;
        }
        .card {
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .header {
            border-bottom: 2px solid #b22222;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }
        .brand {
            font-size: 22px;
            font-weight: bold;
            color: #b22222;
            margin: 0;
        }
        .subtitle {
            font-size: 12px;
            color: #666;
            margin-top: 4px;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
            color: #333;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 6px 0;
            flex-wrap: wrap;
            gap: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background: #f8f8f8;
            width: 35%;
        }
        .total {
            background: #fff3f3;
            font-weight: bold;
            color: #b22222;
        }
        .footer {
            margin-top: 24px;
            font-size: 11px;
            color: #777;
            text-align: center;
        }
        .print-btn {
            display: inline-block;
            margin-top: 16px;
            padding: 8px 14px;
            background: #b22222;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }
        @media print {
            body { background: white; }
            .card { box-shadow: none; border-color: #ccc; }
            .print-btn { display: none; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="header">
            <div class="brand">RM.Nasi Kapau Masakan Padang</div>
            <div class="subtitle">Slip Gaji Karyawan</div>
            <div class="title">SLIP GAJI</div>
            <div class="info-row">
                <span><strong>Periode:</strong> {{ \Illuminate\Support\Str::of($payroll->periode_awal)->explode('-')->reverse()->join('/') }} s/d {{ \Illuminate\Support\Str::of($payroll->periode_akhir)->explode('-')->reverse()->join('/') }}</span>
                <span><strong>Status:</strong> {{ $payroll->status }}</span>
            </div>
        </div>

        <table>
            <tr>
                <th>Nama Karyawan</th>
                <td>{{ $payroll->user->name }}</td>
            </tr>
            <tr>
                <th>Jabatan</th>
                <td>{{ $payroll->user->jabatan ?? '-' }}</td>
            </tr>
            <tr>
                <th>Jenis Gaji</th>
                <td>{{ $payroll->jenis_gaji }}</td>
            </tr>
            <tr>
                <th>Gaji Pokok</th>
                <td>Rp {{ number_format($payroll->gaji_pokok, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Nominal Lembur</th>
                <td>Rp {{ number_format($payroll->lembur, 0, ',', '.') }}</td>
            </tr>
            <tr class="total">
                <th>Total Gaji</th>
                <td>Rp {{ number_format($payroll->jumlah_gaji, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="footer">
            Dicetak pada {{ date('d-m-Y H:i') }}
        </div>

        <div style="text-align:center;">
            <a href="javascript:window.print()" class="print-btn">Unduh / Cetak PDF</a>
        </div>
    </div>
</div>
</body>
</html>
