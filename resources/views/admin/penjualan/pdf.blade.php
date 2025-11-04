<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan Sampah</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Laporan Penjualan Sampah</h1>
    <p><strong>Tanggal:</strong> {{ now()->format('d F Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Sampah</th>
                <th>Berat (kg)</th>
                <th>Total Harga</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penjualan as $p)
                <tr>
                    <td>{{ $p->sampah->nama }} ({{ $p->sampah->jenisSampah->nama }})</td>
                    <td>{{ $p->berat }}</td>
                    <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                    <td>{{ $p->tanggal_penjualan->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>