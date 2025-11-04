{{-- resources/views/admin/articles/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Kelola Artikel')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<style>
    .hover-row:hover { background-color: #f0fdf4 !important; transition: 0.2s; }
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m5 4H9"></path>
                        </svg>
                        Kelola Artikel
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">Buat dan kelola artikel informatif</p>
                </div>
                <a href="{{ route('admin.articles.create') }}"
                   class="inline-flex items-center px-5 py-3 bg-green-600 hover:bg-green-700 text-white font-medium text-sm rounded-xl shadow-md transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Artikel
                </a>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">No</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Judul</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($articles as $index => $article)
                            <tr class="hover-row">
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $articles->firstItem() + $index }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                    <div class="flex items-center space-x-3">
                                        @if($article->image_path) <!-- PERBAIKI: gunakan image_path -->
                                            <img src="{{ asset('storage/' . $article->image_path) }}" alt="{{ $article->title }}"
                                                 class="w-10 h-10 rounded-lg object-cover shadow-sm">
                                        @else
                                            <div class="w-10 h-10 bg-gray-200 border-2 border-dashed rounded-lg"></div>
                                        @endif
                                        <div>
                                            <p class="font-medium text-gray-900">{{ Str::limit($article->title, 50) }}</p>
                                            <p class="text-xs text-gray-500">{{ Str::limit(strip_tags($article->content), 80) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $article->created_at->format('d M Y') }}
                                </td>

                                <!-- AKSI: EDIT & HAPUS (RAPHI) -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('admin.articles.edit', $article) }}"
                                           class="flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-lg hover:bg-indigo-100 transition text-sm font-medium">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H11v-.172l-3.414-3.414a2 2 0 012.828-2.828z"/>
                                            </svg>
                                            Edit
                                        </a>

                                        <form id="delete-{{ $article->id }}"
                                              action="{{ route('admin.articles.destroy', $article) }}"
                                              method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="button" onclick="confirmDelete({{ $article->id }})"
                                                    class="flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition text-sm font-medium">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-16 text-gray-500">
                                    <svg class="w-16 h-16 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Belum ada artikel.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                {{ $articles->links('pagination::tailwind') }}
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

    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus artikel?',
            text: "Data akan dihapus permanen.",
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
                document.getElementById(`delete-${id}`).submit();
            }
        });
    }
</script>
@endpush
@endsection