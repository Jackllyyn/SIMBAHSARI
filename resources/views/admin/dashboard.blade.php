@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 lg:p-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">
            Dashboard Admin - SIMBAHSARI
        </h1>
        <button onclick="location.reload()" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium shadow transition">
            Refresh
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Sampah Masuk -->
        <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 text-white p-6 rounded-xl shadow-lg transform hover:-translate-y-1 transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold opacity-90">Sampah Masuk</h3>
                    <p class="text-3xl font-bold mt-1">
                        {{ rtrim(rtrim(number_format($totalSampahMasuk, 2, '.', ''), '0'), '.') }} kg
                    </p>
                </div>
                <svg class="w-10 h-10 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h-4m-4 0H5"></path>
                </svg>
            </div>
        </div>

        <!-- Sampah Keluar -->
        <div class="bg-gradient-to-br from-red-500 to-red-600 text-white p-6 rounded-xl shadow-lg transform hover:-translate-y-1 transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold opacity-90">Sampah Keluar</h3>
                    <p class="text-3xl font-bold mt-1">
                        {{ rtrim(rtrim(number_format($totalSampahKeluar, 2, '.', ''), '0'), '.') }} kg
                    </p>
                </div>
                <svg class="w-10 h-10 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7m16 0l-8 4-8-4"></path>
                </svg>
            </div>
        </div>

        <!-- Saldo Bank -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 text-white p-6 rounded-xl shadow-lg transform hover:-translate-y-1 transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold opacity-90">Saldo Bank</h3>
                    <p class="text-3xl font-bold mt-1">Rp {{ number_format($saldoBank, 0, ',', '.') }}</p>
                </div>
                <svg class="w-10 h-10 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
            </div>
        </div>

        <!-- Nasabah -->
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 text-white p-6 rounded-xl shadow-lg transform hover:-translate-y-1 transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold opacity-90">Nasabah</h3>
                    <p class="text-3xl font-bold mt-1">{{ $jumlahNasabah }}</p>
                </div>
                <svg class="w-10 h-10 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H9v-1c0-1.657 1.343-3 3-3h0c1.657 0 3 1.343 3 3v1z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- EXPORT LAPORAN -->
<div class="bg-white rounded-xl shadow-lg p-6 mb-6">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Download Laporan Bulanan</h3>
    <form method="GET" action="{{ route('admin.laporan.pdf') }}" class="flex gap-3 items-end flex-wrap">
        <div>
            <label class="block text-sm font-medium text-gray-700">Bulan</label>
            <select name="bulan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                @for($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}" {{ $i == date('n') ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                </option>
                @endfor
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Tahun</label>
            <select name="tahun" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                @for($y = date('Y'); $y >= date('Y')-5; $y--)
                <option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>
        <div>
            <button type="submit" formaction="{{ route('admin.laporan.pdf') }}" 
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                PDF
            </button>
            <button type="submit" formaction="{{ route('admin.laporan.excel') }}" 
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                Excel
            </button>
        </div>
    </form>
</div>

    <!-- GRAFIK BULANAN -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Grafik Sampah -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Tren Sampah Bulanan</h3>
            <canvas id="chartSampah"></canvas>
        </div>

        <!-- Grafik Saldo -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Pertumbuhan Saldo</h3>
            <canvas id="chartSaldo"></canvas>
        </div>
    </div>

    <!-- Grafik Keuangan -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Keuangan Bulanan</h3>
        <canvas id="chartKeuangan"></canvas>
    </div>

    <!-- Stok Saat Ini -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <h3 class="text-lg font-bold text-gray-800 mb-2">Stok Sampah Saat Ini</h3>
        <p class="text-3xl font-bold text-indigo-600">
            {{ rtrim(rtrim(number_format($totalSampahMasuk - $totalSampahKeluar, 2, '.', ''), '0'), '.') }} kg
        </p>
        <p class="text-sm text-gray-500 mt-1">
            ({{ rtrim(rtrim(number_format($totalSampahMasuk, 2, '.', ''), '0'), '.') }} kg masuk - 
             {{ rtrim(rtrim(number_format($totalSampahKeluar, 2, '.', ''), '0'), '.') }} kg keluar)
        </p>
    </div>

    <!-- Riwayat Penjualan -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">Penjualan Sampah</h2>
            <form method="GET">
                <div class="relative">
                    <input type="text" name="search_penjualan" value="{{ $searchPenjualan }}"
                           placeholder="Cari sampah / jenis..."
                           class="w-48 pl-9 pr-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500">
                    <svg class="absolute left-2.5 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 10 14 0z"></path>
                    </svg>
                </div>
            </form>
        </div>

        @if($penjualanSampahs->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="text-xs uppercase bg-gray-100 text-gray-600">
                    <tr>
                        <th class="px-4 py-3">Sampah</th>
                        <th class="px-4 py-3">Jenis</th>
                        <th class="px-4 py-3 text-right">Berat</th>
                        <th class="px-4 py-3 text-right">Harga</th>
                        <th class="px-4 py-3">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($penjualanSampahs as $p)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">{{ $p->sampah->nama }}</td>
                        <td class="px-4 py-3">{{ $p->sampah->jenisSampah->nama ?? '-' }}</td>
                        <td class="px-4 py-3 text-right">
                            {{ rtrim(rtrim(number_format($p->berat, 2, '.', ''), '0'), '.') }} kg
                        </td>
                        <td class="px-4 py-3 text-right text-green-600 font-medium">
                            +Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-gray-500">
                            {{ $p->tanggal_penjualan?->format('d-m-Y') ?? '-' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $penjualanSampahs->appends(['search_penjualan' => $searchPenjualan])->links('pagination::tailwind') }}
        </div>
        @else
        <p class="text-center text-gray-500 py-8">Tidak ada data penjualan.</p>
        @endif
    </div>

    <!-- Riwayat Penarikan -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">Penarikan Saldo Nasabah</h2>
            <form method="GET">
                <div class="relative">
                    <input type="text" name="search_penarikan" value="{{ $searchPenarikan }}"
                           placeholder="Cari nama nasabah..."
                           class="w-48 pl-9 pr-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-red-500">
                    <svg class="absolute left-2.5 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 10 14 0z"></path>
                    </svg>
                </div>
            </form>
        </div>

        @if($penarikans->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="text-xs uppercase bg-gray-100 text-gray-600">
                    <tr>
                        <th class="px-4 py-3">Nasabah</th>
                        <th class="px-4 py-3 text-right">Jumlah</th>
                        <th class="px-4 py-3">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($penarikans as $p)
                    <tr class="hover:bg-red-50">
                        <td class="px-4 py-3 font-medium">{{ $p->nasabah->nama }}</td>
                        <td class="px-4 py-3 text-right text-red-600 font-medium">
                            -Rp {{ number_format($p->jumlah, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-gray-500">
                            {{ $p->tanggal?->format('d-m-Y H:i') ?? '-' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $penarikans->appends(['search_penarikan' => $searchPenarikan])->links('pagination::tailwind') }}
        </div>
        @else
        <p class="text-center text-gray-500 py-8">Tidak ada data penarikan.</p>
        @endif
    </div>
</div>

<!-- CHART.JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Grafik Sampah
        new Chart(document.getElementById('chartSampah'), {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [
                    {
                        label: 'Sampah Masuk (kg)',
                        data: @json($sampahData['masuk']),
                        borderColor: 'rgb(99, 102, 241)',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Sampah Keluar (kg)',
                        data: @json($sampahData['keluar']),
                        borderColor: 'rgb(239, 68, 68)',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'top' } },
                scales: { y: { beginAtZero: true } }
            }
        });

        // Grafik Saldo
        new Chart(document.getElementById('chartSaldo'), {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Saldo (Rp)',
                    data: @json($saldoData),
                    borderColor: 'rgb(34, 197, 94)',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'top' } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => 'Rp ' + value.toLocaleString('id-ID')
                        }
                    }
                }
            }
        });

        // Grafik Keuangan
        new Chart(document.getElementById('chartKeuangan'), {
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: [
                    {
                        label: 'Pendapatan (Rp)',
                        data: @json($keuanganData['pendapatan']),
                        backgroundColor: 'rgb(34, 197, 94)'
                    },
                    {
                        label: 'Pengeluaran (Rp)',
                        data: @json($keuanganData['pengeluaran']),
                        backgroundColor: 'rgb(239, 68, 68)'
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'top' } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => 'Rp ' + value.toLocaleString('id-ID')
                        }
                    }
                }
            }
        });
    });
</script>

<style>
    .transform { transition: all 0.2s ease; }
    .hover\:-translate-y-1:hover { transform: translateY(-4px); }
</style>
@endsection