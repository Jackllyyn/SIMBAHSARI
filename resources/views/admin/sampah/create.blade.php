{{-- resources/views/admin/sampah/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Sampah')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-green-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
            <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                <svg class="w-8 h-8 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Sampah
            </h1>
        </div>

        <form action="{{ route('admin.sampah.store') }}" method="POST" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            @csrf

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Sampah</label>
                <input type="text" name="nama" value="{{ old('nama') }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-sm">
                @error('nama') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Sampah</label>
                <select name="jenis_sampah_id" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-sm">
                    <option value="">Pilih Jenis</option>
                    @foreach ($jenisSampahs as $j)
                        <option value="{{ $j->id }}" {{ old('jenis_sampah_id') == $j->id ? 'selected' : '' }}>
                            {{ $j->nama }} (Rp {{ number_format($j->harga_per_kg, 0, ',', '.') }}/kg)
                        </option>
                    @endforeach
                </select>
                @error('jenis_sampah_id') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                <textarea name="deskripsi" rows="4"
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-sm">{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-xl shadow-md transition">
                    Simpan
                </button>
                <a href="{{ route('admin.sampah.index') }}"
                   class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection