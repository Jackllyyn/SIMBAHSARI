{{-- resources/views/admin/nasabah/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Daftar Nasabah')

@push('styles')
<style>
    .table-row-hover:hover {
        background-color: #f9fafb;
        transition: all 0.2s ease;
    }
    .search-input {
        transition: all 0.3s ease;
    }
    .search-input:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Card Utama -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <!-- Header -->
            <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <h1 class="text-2xl font-bold text-gray-900">
                        Daftar Nasabah
                    </h1>
                    <a href="{{ route('admin.nasabah.create') }}"
                       class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-lg shadow-sm transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Nasabah
                    </a>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="p-4 border-b border-gray-200 bg-gray-50">
                <div class="relative max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" id="search" placeholder="Cari nama atau email..."
                           class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 search-input text-sm">
                </div>
            </div>

            <!-- Tabel -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200" id="nasabah-table">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Alamat</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No Telepon</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="table-body">
                        @forelse ($nasabahs as $nasabah)
                            <tr class="table-row-hover" data-nama="{{ strtolower($nasabah->nama) }}" data-email="{{ strtolower($nasabah->user->email) }}">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $nasabah->nama }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $nasabah->user->email }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">{{ $nasabah->alamat }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $nasabah->no_telepon }}</td>
                                <td class="px-6 py-4 text-sm font-medium space-x-4">
                                    <a href="{{ route('admin.nasabah.edit', $nasabah) }}"
                                       class="text-blue-600 hover:text-blue-800 font-medium transition">Edit</a>

                                    <!-- Form Hapus -->
                                    <form id="delete-form-{{ $nasabah->id }}"
                                          action="{{ route('admin.nasabah.destroy', $nasabah) }}"
                                          method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>

                                    <button type="button"
                                            onclick="confirmDelete({{ $nasabah->id }})"
                                            class="text-red-600 hover:text-red-800 font-medium transition">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr id="no-data">
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500 text-sm">
                                    Belum ada data nasabah.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $nasabahs->appends(request()->query())->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Auto-hide success toast (3 detik)
    @if(session('success'))
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}'
        });
    @endif

    // Konfirmasi Hapus
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${id}`).submit();
            }
        });
    }

    // Real-time Search
    document.getElementById('search').addEventListener('input', function(e) {
        const query = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('#table-body tr');
        const noDataRow = document.getElementById('no-data');
        let visible = 0;

        rows.forEach(row => {
            if (row.id === 'no-data') return;
            const nama = row.getAttribute('data-nama');
            const email = row.getAttribute('data-email');
            if (nama.includes(query) || email.includes(query)) {
                row.style.display = '';
                visible++;
            } else {
                row.style.display = 'none';
            }
        });

        // Tampilkan "tidak ada data" jika tidak ada hasil
        if (visible === 0 && rows.length > 1) {
            if (!noDataRow) {
                const tr = document.createElement('tr');
                tr.id = 'no-data';
                tr.innerHTML = `<td colspan="5" class="px-6 py-12 text-center text-gray-500 text-sm">Tidak ada data yang cocok.</td>`;
                document.getElementById('table-body').appendChild(tr);
            } else {
                noDataRow.style.display = '';
            }
        } else {
            if (noDataRow) noDataRow.style.display = 'none';
        }
    });
</script>
@endpush
@endsection