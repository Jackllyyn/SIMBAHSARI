{{-- resources/views/admin/sampah/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Kelola Sampah & Jenis')

@push('styles')
<style>
    .hover-row:hover { background-color: #f0fdf4 !important; transition: 0.2s; }
    .hover-jenis:hover { background-color: #f0f7ff !important; transition: 0.2s; }
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
                        Kelola Sampah & Jenis
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">Satu halaman untuk semua pengelolaan sampah</p>
                </div>
            </div>
        </div>

        <!-- ==================== JENIS SAMPAH ==================== -->
        <div class="mb-12">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800">Jenis Sampah</h2>
                <a href="{{ route('admin.sampah.create_jenis') }}"
                   class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-xl shadow-md transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Jenis
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-blue-50 to-blue-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase">Harga/Kg</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($jenisSampahs as $jenis)
                            <tr class="hover-jenis">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $jenis->nama }}</td>
                                <td class="px-6 py-4 text-sm text-green-700 font-bold">
                                    Rp {{ number_format($jenis->harga_per_kg, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-sm space-x-3">
                                    <a href="{{ route('admin.sampah.editJenis', $jenis) }}" class="text-indigo-600 hover:text-indigo-800">Edit</a>
                                    <form id="delete-jenis-{{ $jenis->id }}"
                                          action="{{ route('admin.sampah.destroyJenis', $jenis) }}"
                                          method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDeleteJenis({{ $jenis->id }})"
                                                class="text-red-600 hover:text-red-800">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-12 text-gray-500">
                                    <svg class="w-16 h-16 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h-4m-4 0H7m2-4h6m-6 0h6m-6-4h6m-6 0h6"></path>
                                    </svg>
                                    Belum ada jenis sampah.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="bg-blue-50 px-6 py-3 border-t">
                    {{ $jenisSampahs->links('pagination::tailwind') }}
                </div>
            </div>
        </div>

        <!-- ==================== DATA SAMPAH ==================== -->
        <div>
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800">Data Sampah</h2>
                <a href="{{ route('admin.sampah.create') }}"
                   class="inline-flex items-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium text-sm rounded-xl shadow-md transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Sampah
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-green-50 to-green-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-green-700 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-green-700 uppercase">Jenis</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-green-700 uppercase">Deskripsi</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-green-700 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($sampahs as $sampah)
                            <tr class="hover-row">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $sampah->nama }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $sampah->jenisSampah->nama ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ Str::limit($sampah->deskripsi, 50) }}
                                </td>
                                <td class="px-6 py-4 text-sm space-x-3">
                                    <a href="{{ route('admin.sampah.edit', $sampah) }}" class="text-indigo-600 hover:text-indigo-800">Edit</a>
                                    <form id="delete-sampah-{{ $sampah->id }}"
                                          action="{{ route('admin.sampah.destroy', $sampah) }}"
                                          method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDeleteSampah({{ $sampah->id }})"
                                                class="text-red-600 hover:text-red-800">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-12 text-gray-500">
                                    <svg class="w-16 h-16 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                    Belum ada data sampah.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="bg-green-50 px-6 py-3 border-t">
                    {{ $sampahs->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        const Toast = Swal.mixin({
            toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true,
            background: '#ecfdf5', color: '#065f46',
            didOpen: (toast) => { toast.addEventListener('mouseenter', Swal.stopTimer); toast.addEventListener('mouseleave', Swal.resumeTimer); }
        });
        Toast.fire({ icon: 'success', title: '{{ session('success') }}' });
    @endif

    function confirmDeleteJenis(id) {
        Swal.fire({
            title: 'Hapus jenis sampah?', text: "Data akan dihapus permanen.", icon: 'warning',
            showCancelButton: true, confirmButtonColor: '#dc2626', cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus', cancelButtonText: 'Batal',
            customClass: { popup: 'rounded-2xl', confirmButton: 'rounded-xl', cancelButton: 'rounded-xl' }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-jenis-${id}`).submit();
            }
        });
    }

    function confirmDeleteSampah(id) {
        Swal.fire({
            title: 'Hapus sampah ini?', text: "Data akan dihapus permanen.", icon: 'warning',
            showCancelButton: true, confirmButtonColor: '#dc2626', cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus', cancelButtonText: 'Batal',
            customClass: { popup: 'rounded-2xl', confirmButton: 'rounded-xl', cancelButton: 'rounded-xl' }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-sampah-${id}`).submit();
            }
        });
    }
</script>
@endpush
@endsection