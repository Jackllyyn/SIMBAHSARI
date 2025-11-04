<table>
    <tr><th colspan="6" style="text-align:center; font-size:16pt; font-weight:bold;">BANK SAMPAH SIMBAHSARI</th></tr>
    <tr><th colspan="6" style="text-align:center;">
    {{ \Carbon\Carbon::createFromFormat('Y-m', $tahun . '-' . sprintf('%02d', $bulan))->format('F Y') }}
</th></tr>
    <tr><td colspan="6"></td></tr>
</table>

<table border="1">
    <tr><th>Ringkasan</th><th>Nilai</th></tr>
    <tr><td>Sampah Masuk</td><td>{{ number_format($masuk, 2) }} kg</td></tr>
    <tr><td>Sampah Keluar</td><td>{{ number_format($keluar, 2) }} kg</td></tr>
    <tr><td>Pendapatan</td><td>Rp {{ number_format($pendapatan, 0, ',', '.') }}</td></tr>
    <tr><td>Pengeluaran</td><td>Rp {{ number_format($pengeluaran, 0, ',', '.') }}</td></tr>
    <tr><td>Saldo</td><td>Rp {{ number_format($saldo, 0, ',', '.') }}</td></tr>
</table>

<br>

<table border="1">
    <tr><th colspan="4">PENJUALAN</th></tr>
    <tr><th>Sampah</th><th>Berat</th><th>Harga</th><th>Tanggal</th></tr>
    @foreach($penjualan as $p)
    <tr>
        <td>{{ $p->sampah->nama }}</td>
        <td>{{ number_format($p->berat, 2) }}</td>
        <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
        <td>{{ $p->tanggal_penjualan->format('d-m-Y') }}</td>
    </tr>
    @endforeach
</table>

<br>

<table border="1">
    <tr><th colspan="3">PENARIKAN</th></tr>
    <tr><th>Nasabah</th><th>Jumlah</th><th>Tanggal</th></tr>
    @foreach($penarikan as $p)
    <tr>
        <td>{{ $p->nasabah->nama }}</td>
        <td>Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
        <td>{{ $p->tanggal->format('d-m-Y H:i') }}</td>
    </tr>
    @endforeach
</table>