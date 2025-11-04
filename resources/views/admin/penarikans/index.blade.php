{{-- resources/views/admin/penarikans/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Riwayat Penarikan')

@push('styles')
<style>
    .hover-row:hover {
        background-color: #fef2f2 !important;
        transition: background-color 0.2s ease;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-red-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 flex items-center">
                        <svg class="w-8 h-8 mr-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                        </svg>
                        Riwayat Penarikan Saldo
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">Lacak semua penarikan saldo nasabah</p>
                </div>
                <a href="{{ route('admin.penarikans.create') }}"
                   class="inline-flex items-center px-5 py-3 bg-red-600 hover:bg-red-700 text-white font-medium text-sm rounded-xl shadow-md transition-all duration-200 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tarik Saldo
                </a>
            </div>
        </div>

        <!-- Filter Card -->
        <form method="GET" action="{{ route('admin.penarikans.index') }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                <!-- Search -->
                <div class="relative">
                    <label class="block text-xs font-semibold text-gray-700 mb-2">Cari</label>
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none mt-8">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Nama / jumlah"
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition text-sm">
                </div>

                <!-- Nasabah -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-2">Nasabah</label>
                    <select name="nasabah_id" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition text-sm">
                        <option value="">Semua Nasabah</option>
                        @foreach ($nasabahs as $n)
                            <option value="{{ $n->id }}" {{ request('nasabah_id') == $n->id ? 'selected' : '' }}>
                                {{ $n->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-2">Dari</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <input type="date" name="dari" value="{{ request('dari') }}"
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition text-sm">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-2">Sampai</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <input type="date" name="sampai" value="{{ request('sampai') }}"
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition text-sm">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="submit"
                        class="px-5 py-3 bg-red-600 hover:bg-red-700 text-white font-medium text-sm rounded-xl shadow-md transition">
                    Filter
                </button>
                <a href="{{ route('admin.penarikans.index') }}"
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
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($penarikans as $p)
                            <tr class="hover-row">
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $p->nasabah->nama }}</td>
                                <td class="px-6 py-4 text-sm font-bold text-red-600">
                                    -Rp {{ number_format($p->jumlah, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $p->created_at->format('d M Y H:i') }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <form id="delete-form-{{ $p->id }}"
                                          action="{{ route('admin.penarikans.destroy', $p) }}"
                                          method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmCancel({{ $p->id }})"
                                                class="text-red-600 hover:text-red-800 font-medium transition">
                                            Batalkan
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-16">
                                    <div class="text-gray-400">
                                        <svg class="w-20 h-20 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        <p class="text-lg font-medium text-gray-600">Belum ada penarikan</p>
                                        <p class="text-sm text-gray-500">Semua saldo masih aman.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                {{ $penarikans->appends(request()->query())->links('pagination::tailwind') }}
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
            background: '#fee2e2',
            color: '#991b1b',
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

    function confirmCancel(id) {
        Swal.fire({
            title: 'Batalkan penarikan?',
            text: "Saldo nasabah dan bank akan dikembalikan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Batalkan',
            cancelButtonText: 'Tidak',
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