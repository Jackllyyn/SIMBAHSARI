{{-- resources/views/admin/galleries/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Kelola Galeri')

@push('styles')
<style>
    .gallery-card:hover { transform: translateY(-4px); transition: all 0.3s ease; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); }
    .hover-row:hover { background-color: #f0fdf4 !important; }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-indigo-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 flex items-center">
                        <svg class="w-8 h-8 mr-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Kelola Galeri
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">Tambah dan atur gambar galeri</p>
                </div>
                <a href="{{ route('admin.galleries.create') }}"
                   class="inline-flex items-center px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm rounded-xl shadow-md transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Gambar
                </a>
            </div>
        </div>

        <!-- Gallery Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($galleries as $gallery)
                <div class="gallery-card bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="aspect-w-1 aspect-h-1">
                        <img src="{{ asset('storage/' . $gallery->image_path) }}"
                             alt="{{ $gallery->title }}"
                             class="w-full h-48 object-cover">
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-900 text-sm">{{ Str::limit($gallery->title, 30) }}</h3>
                        @if($gallery->description)
                            <p class="text-xs text-gray-500 mt-1">{{ Str::limit($gallery->description, 50) }}</p>
                        @endif
                        <div class="mt-3 flex justify-end">
                            <form id="delete-{{ $gallery->id }}"
                                  action="{{ route('admin.galleries.destroy', $gallery) }}"
                                  method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="button" onclick="confirmDelete({{ $gallery->id }})"
                                        class="text-red-600 hover:text-red-800 text-xs font-medium">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <svg class="w-20 h-20 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-gray-500">Belum ada gambar di galeri.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8 flex justify-center">
            {{ $galleries->links('pagination::tailwind') }}
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        const Toast = Swal.mixin({
            toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true,
            background: '#eef2ff', color: '#4f46e5',
            didOpen: (toast) => { toast.addEventListener('mouseenter', Swal.stopTimer); toast.addEventListener('mouseleave', Swal.resumeTimer); }
        });
        Toast.fire({ icon: 'success', title: '{{ session('success') }}' });
    @endif

    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus gambar?', text: "Gambar akan dihapus permanen.", icon: 'warning',
            showCancelButton: true, confirmButtonColor: '#dc2626', cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus', cancelButtonText: 'Batal',
            customClass: { popup: 'rounded-2xl', confirmButton: 'rounded-xl', cancelButton: 'rounded-xl' }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-${id}`).submit();
            }
        });
    }
</script>
@endpush
@endsection