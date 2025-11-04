{{-- resources/views/admin/galleries/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Gambar Galeri')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-indigo-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">

        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                        <svg class="w-8 h-8 mr-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Gambar
                    </h1>
                </div>
                <a href="{{ route('admin.galleries.index') }}"
                   class="text-gray-600 hover:text-gray-800 font-medium">Kembali</a>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data"
              class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            @csrf

            <!-- Judul -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Gambar</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm">
                @error('title') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Gambar -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Gambar</label>
                <input type="file" name="image" id="image" accept="image/*" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                @error('image') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Preview -->
            <div id="image-preview" class="hidden mb-6">
                <p class="text-sm font-semibold text-gray-700 mb-2">Pratinjau:</p>
                <img id="preview-img" src="" alt="Preview" class="w-full h-64 object-cover rounded-xl shadow-md">
            </div>

            <!-- Deskripsi -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi (Opsional)</label>
                <textarea name="description" rows="4"
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm">{{ old('description') }}</textarea>
                @error('description') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Tombol -->
            <div class="flex gap-3">
                <button type="submit"
                        class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-md transition">
                    Simpan Gambar
                </button>
                <a href="{{ route('admin.galleries.index') }}"
                   class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('image-preview');
        const img = document.getElementById('preview-img');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            preview.classList.add('hidden');
        }
    });
</script>
@endpush
@endsection