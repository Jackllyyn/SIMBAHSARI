{{-- resources/views/admin/setoran_sampah/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Setoran Sampah')

@push('styles')
<style>
    .hover-row:hover {
        background-color: #f0fdf4 !important;
        transition: background-color 0.2s ease;
    }
    .input-focus:focus {
        outline: none;
        ring: 2px solid #10b981;
        border-color: #10b981;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-green-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 flex items-center">
                        <svg class="w-8 h-8 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h-4m-4 0H7m2-4h6m-6 0h6m-6-4h6m-6 0h6"></path>
                        </svg>
                        Setoran Sampah
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">Kelola semua transaksi setoran nasabah dengan mudah</p>
                </div>
                <a href="{{ route('admin.setoran_sampah.create') }}"
                   class="inline-flex items-center px-5 py-3 bg-green-600 hover:bg-green-700 text-white font-medium text-sm rounded-xl shadow-md transition-all duration-200 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Setoran
                </a>
            </div>
        </div>

        <!-- Filter Card -->
        <form method="GET" action="{{ route('admin.setoran_sampah.index') }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <!-- Search -->
                <div class="relative">
                    <label class="block text-xs font-semibold text-gray-700 mb-2">Pencarian</label>
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none mt-8">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Nama / Sampah / Tanggal"
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-sm">
                </div>

                <!-- Nasabah -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-2">Nasabah</label>
                    <select name="nasabah_id" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-sm">
                        <option value="">Semua Nasabah</option>
                        @foreach ($nasabahs as $nasabah)
                            <option value="{{ $nasabah->id }}" {{ request('nasabah_id') == $nasabah->id ? 'selected' : '' }}>
                                {{ $nasabah->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Sampah -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-2">Jenis Sampah</label>
                    <select name="sampah_id" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-sm">
                        <option value="">Semua Sampah</option>
                        @foreach ($sampahs as $sampah)
                            <option value="{{ $sampah->id }}" {{ request('sampah_id') == $sampah->id ? 'selected' : '' }}>
                                {{ $sampah->nama }} ({{ $sampah->jenisSampah->nama }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal Dari -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-2">Dari Tanggal</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}"
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-sm">
                    </div>
                </div>

                <!-- Tanggal Sampai -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-2">Sampai Tanggal</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}"
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-sm">
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="submit"
                        class="px-5 py-3 bg-green-600 hover:bg-green-700 text-white font-medium text-sm rounded-xl shadow-md transition">
                    Terapkan Filter
                </button>
                <a href="{{ route('admin.setoran_sampah.index') }}"
                   class="px-5 py-3 border border-gray-300 text-gray-700 font-medium text-sm rounded-xl hover:bg-gray-50 transition">
                    Reset
                </a>
            </div>
        </form>

        <!-- Table Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Nasabah</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Sampah</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Berat</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Total Harga</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($setoranSampahs as $setoran)
                            <tr class="hover-row border-b">
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $setoran->nasabah->nama }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <div>
                                        <div class="font-medium text-gray-800">{{ $setoran->sampah->nama }}</div>
                                        <div class="text-xs text-gray-500">{{ $setoran->sampah->jenisSampah->nama }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $setoran->berat }} kg
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-bold text-green-700">
                                    Rp {{ number_format($setoran->total_harga, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $setoran->tanggal_setor?->format('d M Y') ?? '—' }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium space-x-3">
                                    <a href="{{ route('admin.setoran_sampah.edit', $setoran) }}"
                                       class="text-indigo-600 hover:text-indigo-800 transition">Edit</a>

                                    <form id="delete-form-{{ $setoran->id }}"
                                          action="{{ route('admin.setoran_sampah.destroy', $setoran) }}"
                                          method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $setoran->id }})"
                                                class="text-red-600 hover:text-red-800 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-16">
                                    <div class="text-gray-400">
                                        <svg class="w-20 h-20 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                        </svg>
                                        <p class="text-lg font-medium text-gray-600">Belum ada data setoran</p>
                                        <p class="text-sm text-gray-500">Klik "Tambah Setoran" untuk memulai.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                {{ $setoranSampahs->appends(request()->query())->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            background: '#ecfdf5',
            color: '#065f46',
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
        Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}'
        });
    @endif

    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus setoran?',
            text: "Data akan dihapus permanen dan saldo nasabah dikurangi.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-2xl',
                confirmButton: 'rounded-xl',
                cancelButton: 'rounded-xl'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${id}`).submit();
            }
        });
    }
</script>
@endpush
@endsection