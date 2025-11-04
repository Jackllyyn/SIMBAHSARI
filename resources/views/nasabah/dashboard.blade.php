@extends('layouts.nasabah')

@section('content')
<div class="container mx-auto p-4 max-w-7xl" x-data="{ editMode: false }">

    <!-- Header -->
    <div class="mb-8 flex items-center gap-3">
        <svg class="w-9 h-9 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        <div>
            <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-green-600">
                Dashboard Nasabah
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">
                Selamat datang, <strong>{{ $nasabah->nama }}</strong>
            </p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-lg mb-6 animate-fade-in flex items-center gap-2 rounded-xl">
            <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Profil & Saldo -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Profil Card -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                        <svg class="w-7 h-7 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7 0 00-13.074.003z"/>
                        </svg>
                        Profil Nasabah
                    </h2>
                    <a href="{{ route('nasabah.profile.edit') }}" class="btn btn-sm btn-outline btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </a>
                </div>

                <div x-show="!editMode" x-transition class="space-y-4">
                    <div class="flex flex-col sm:flex-row items-center gap-4">
                        <div class="avatar hover:scale-110 transition-transform">
                            <div class="w-20 rounded-full ring ring-primary ring-offset-2 ring-offset-base-100">
                                @if($nasabah->foto)
                                    <img src="{{ Storage::url($nasabah->foto) }}" alt="Foto" class="object-cover" />
                                @else
                                    <div class="bg-gradient-to-br from-blue-400 to-green-500 w-full h-full flex items-center justify-center text-2xl font-bold text-white">
                                        {{ strtoupper(substr($nasabah->nama, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="text-center sm:text-left flex-1">
                            <p class="font-semibold text-lg text-gray-900 dark:text-gray-100">{{ $nasabah->nama }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {{ Auth::user()->email }}
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div class="p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <p class="text-gray-600 dark:text-gray-400 font-medium flex items-center gap-2">
                                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                                Alamat
                            </p>
                            <p class="text-gray-800 dark:text-gray-200">{{ $nasabah->alamat ?? 'Belum diisi' }}</p>
                        </div>
                        <div class="p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <p class="text-gray-600 dark:text-gray-400 font-medium flex items-center gap-2">
                                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                No. Telepon
                            </p>
                            <p class="text-gray-800 dark:text-gray-200">{{ $nasabah->no_telepon ?? 'Belum diisi' }}</p>
                        </div>
                    </div>

                    <!-- SALDO SAAT INI (TIDAK MEMANJANG!) -->
                    <div class="pt-3 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                        <span class="text-lg font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2 whitespace-nowrap">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Saldo Saat Ini
                        </span>
                        <span class="text-xl font-bold text-green-600 dark:text-green-400 whitespace-nowrap overflow-hidden text-ellipsis max-w-xs">
                            Rp {{ number_format($nasabah->saldo, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD TOTAL SALDO (TIDAK MEMANJANG!) -->
        <div class="bg-gradient-to-br from-green-500 to-emerald-600 dark:from-green-600 dark:to-emerald-700 rounded-xl shadow-lg p-6 text-white flex flex-col justify-between hover:scale-105 transition-transform">
            <div>
                <h3 class="text-lg font-semibold mb-2 flex items-center gap-2">
                    <svg class="w-7 h-7 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" />
                    </svg>
                    Total Saldo
                </h3>
                <div class="text-lg font-bold whitespace-nowrap overflow-hidden text-ellipsis max-w-xs">
                    Rp {{ number_format($nasabah->saldo, 0, ',', '.') }}
                </div>
                <p class="text-sm opacity-90 mt-2">Siap ditarik kapan saja</p>
            </div>
            <div class="mt-4 self-end">
                <svg class="w-12 h-12 opacity-70 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Riwayat Setoran & Penarikan -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <!-- Setoran -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow">
            <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                    <svg class="w-7 h-7 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                    Riwayat Setoran Sampah
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-700 text-xs font-medium text-gray-600 dark:text-gray-300">
                            <th class="px-4 py-3 text-left">Sampah</th>
                            <th class="px-4 py-3 text-left">Berat</th>
                            <th class="px-4 py-3 text-left">Harga</th>
                            <th class="px-4 py-3 text-left">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse ($setoranSampahs as $setoran)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-brown-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        {{ $setoran->sampah->nama }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $setoran->sampah->jenisSampah->nama }}</div>
                                </td>
                                <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $setoran->berat }} kg</td>
                                <td class="px-4 py-3 text-green-600 dark:text-green-400 font-medium">+Rp {{ number_format($setoran->total_harga, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $setoran->tanggal_setor?->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-8 text-gray-500 italic">Belum ada setoran</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Penarikan -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow">
            <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                    <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                    </svg>
                    Riwayat Penarikan
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr class="bg-red-50 dark:bg-red-900/20 text-xs font-medium text-gray-600 dark:text-gray-300">
                            <th class="px-4 py-3 text-left">Jumlah</th>
                            <th class="px-4 py-3 text-left">Tanggal</th>
                            <th class="px-4 py-3 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse ($penarikans as $penarikan)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td class="px-4 py-3 text-red-600 dark:text-red-400 font-medium">-Rp {{ number_format($penarikan->jumlah, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $penarikan->tanggal->format('d M Y H:i') }}</td>
                                <td class="px-4 py-3"><span class="badge badge-success badge-sm">Selesai</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center py-8 text-gray-500 italic">Belum ada penarikan</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in { animation: fadeIn 0.4s ease-out; }
</style>
@endsection