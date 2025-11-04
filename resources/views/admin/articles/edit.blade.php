{{-- resources/views/admin/articles/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Artikel')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-green-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">

        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                        <svg class="w-8 h-8 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Artikel
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">Perbarui judul, konten, dan gambar</p>
                </div>
                <a href="{{ route('admin.articles.index') }}"
                   class="text-gray-600 hover:text-gray-800 font-medium text-sm">
                    Kembali
                </a>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data"
              class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            @csrf
            @method('PUT')

            <!-- Judul -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Artikel</label>
                <input type="text" name="title" value="{{ old('title', $article->title) }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-sm">
                @error('title')
                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Konten -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Konten</label>
                <textarea name="content" rows="8" required
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-sm">{{ old('content', $article->content) }}</textarea>
                @error('content')
                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gambar Saat Ini -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Saat Ini</label>
                @if($article->image_path)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $article->image_path) }}"
                             alt="{{ $article->title }}"
                             class="w-32 h-32 object-cover rounded-xl shadow-md">
                    </div>
                    <p class="text-xs text-gray-500">Biarkan kosong jika tidak ingin mengganti gambar.</p>
                @else
                    <p class="text-sm text-gray-500 mb-3">Tidak ada gambar.</p>
                @endif

                <label class="block text-sm font-semibold text-gray-700 mb-2">Ganti Gambar (Opsional)</label>
                <input type="file" name="image" id="image" accept="image/*"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                @error('image')
                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol -->
            <div class="flex gap-3">
                <button type="submit"
                        class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-xl shadow-md transition">
                    Perbarui Artikel
                </button>
                <a href="{{ route('admin.articles.index') }}"
                   class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection