{{-- resources/views/admin/articles/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Artikel')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-green-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">

        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                        <svg class="w-8 h-8 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Artikel
                    </h1>
                </div>
                <a href="{{ route('admin.articles.index') }}"
                   class="text-gray-600 hover:text-gray-800 font-medium">Kembali</a>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data"
              class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            @csrf

            <!-- Judul -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Artikel</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-sm">
                @error('title') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Konten -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Konten</label>
                <textarea name="content" rows="8" required
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-sm">{{ old('content') }}</textarea>
                @error('content') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Gambar -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar (Opsional)</label>
                <div class="flex items-center space-x-4">
                    <div class="flex-1">
                        <input type="file" name="image" id="image" accept="image/*"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                        @error('image') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div id="image-preview" class="hidden">
                        <img id="preview-img" src="" alt="Preview" class="w-24 h-24 object-cover rounded-xl shadow-md">
                    </div>
                </div>
            </div>

            <!-- Tombol -->
            <div class="flex gap-3">
                <button type="submit"
                        class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-xl shadow-md transition">
                    Simpan Artikel
                </button>
                <a href="{{ route('admin.articles.index') }}"
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