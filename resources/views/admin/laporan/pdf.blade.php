<!DOCTYPE html>
<html>
<head>
    <title>Laporan {{ $tahun }}-{{ $bulan }}</title>
    <style>
        body { font-family: Arial; font-size: 12px; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        th, td { border: 1px solid #333; padding: 8px; }
        th { background-color: #f0f0f0; font-weight: bold; }
        .text-right { text-align: right; }
        h3 { margin: 30px 0 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>BANK SAMPAH SIMBAHSARI</h1>
        <h2>Laporan Bulanan: 
    {{ \Carbon\Carbon::createFromFormat('Y-m', $tahun . '-' . sprintf('%02d', $bulan))->format('F Y') }}
</h2>
    </div>

    <table>
        <tr><th colspan="2">RINGKASAN</th></tr>
        <tr><td>Sampah Masuk</td><td class="text-right">{{ number_format($masuk, 2) }} kg</td></tr>
        <tr><td>Sampah Keluar</td><td class="text-right">{{ number_format($keluar, 2) }} kg</td></tr>
        <tr><td>Stok</td><td class="text-right">{{ number_format($masuk - $keluar, 2) }} kg</td></tr>
        <tr><td>Pendapatan</td><td class="text-right">Rp {{ number_format($pendapatan, 0, ',', '.') }}</td></tr>
        <tr><td>Pengeluaran</td><td class="text-right">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</td></tr>
        <tr><td>Saldo</td><td class="text-right">Rp {{ number_format($saldo, 0, ',', '.') }}</td></tr>
    </table>

    <h3>Penjualan Sampah</h3>
    <table>
        <tr><th>Sampah</th><th>Berat</th><th>Harga</th><th>Tanggal</th></tr>
        @foreach($penjualan as $p)
        <tr>
            <td>{{ $p->sampah->nama }}</td>
            <td class="text-right">{{ number_format($p->berat, 2) }} kg</td>
            <td class="text-right">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
            <td>{{ $p->tanggal_penjualan->format('d-m-Y') }}</td>
        </tr>
        @endforeach
    </table>

    <h3>Penarikan Nasabah</h3>
    <table>
        <tr><th>Nasabah</th><th>Jumlah</th><th>Tanggal</th></tr>
        @foreach($penarikan as $p)
        <tr>
            <td>{{ $p->nasabah->nama }}</td>
            <td class="text-right">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
            <td>{{ $p->tanggal->format('d-m-Y H:i') }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>