{{-- resources/views/admin/sampah/create_jenis.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Jenis Sampah')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
            <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                <svg class="w-8 h-8 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Jenis Sampah
            </h1>
        </div>

        <form action="{{ route('admin.sampah.storeJenis') }}" method="POST" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            @csrf

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Jenis</label>
                <input type="text" name="nama" value="{{ old('nama') }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm">
                @error('nama') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Harga per Kg</label>
                <input type="number" name="harga_per_kg" step="1" min="0" value="{{ old('harga_per_kg') }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm">
                @error('harga_per_kg') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl shadow-md transition">
                    Simpan
                </button>
                <!-- DIPERBAIKI: dari .jenis ke .index -->
                <a href="{{ route('admin.sampah.index') }}"
                   class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection