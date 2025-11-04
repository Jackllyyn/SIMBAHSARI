{{-- resources/views/admin/setoran_sampah/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Setoran Sampah')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm p-6 sm:p-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h-4m-4 0H7m2-4h6m-6 0h6m-6-4h6m-6 0h6"></path>
                </svg>
                Tambah Setoran Sampah
            </h1>

            <form action="{{ route('admin.setoran_sampah.store') }}" method="POST" novalidate>
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nasabah -->
                    <div>
                        <label for="nasabah_id" class="block text-sm font-semibold text-gray-700 mb-1.5">Nasabah</label>
                        <select name="nasabah_id" id="nasabah_id"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('nasabah_id') border-red-500 @enderror" required>
                            <option value="">Pilih Nasabah</option>
                            @foreach ($nasabahs as $nasabah)
                                <option value="{{ $nasabah->id }}" {{ old('nasabah_id') == $nasabah->id ? 'selected' : '' }}>{{ $nasabah->nama }}</option>
                            @endforeach
                        </select>
                        @error('nasabah_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sampah -->
                    <div>
                        <label for="sampah_id" class="block text-sm font-semibold text-gray-700 mb-1.5">Jenis Sampah</label>
                        <select name="sampah_id" id="sampah_id"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('sampah_id') border-red-500 @enderror" required>
                            <option value="">Pilih Sampah</option>
                            @foreach ($sampahs as $sampah)
                                <option value="{{ $sampah->id }}" {{ old('sampah_id') == $sampah->id ? 'selected' : '' }}>
                                    {{ $sampah->nama }} ({{ $sampah->jenisSampah->nama }})
                                </option>
                            @endforeach
                        </select>
                        @error('sampah_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Berat (HANYA BILANGAN BULAT) -->
                    <div>
                        <label for="berat" class="block text-sm font-semibold text-gray-700 mb-1.5">Berat (kg)</label>
                        <input type="number" 
                               name="berat" 
                               id="berat" 
                               min="1"
                               placeholder="Contoh: 5"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('berat') border-red-500 @enderror"
                               value="{{ old('berat') }}" 
                               required>
                        @error('berat')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Setor -->
                    <div>
                        <label for="tanggal_setor" class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Setor</label>
                        <input type="date" 
                               name="tanggal_setor" 
                               id="tanggal_setor"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('tanggal_setor') border-red-500 @enderror"
                               value="{{ old('tanggal_setor', now()->format('Y-m-d')) }}" 
                               required>
                        @error('tanggal_setor')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Tombol -->
                <div class="mt-8 flex justify-end gap-3">
                    <a href="{{ route('admin.setoran_sampah.index') }}"
                       class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow-sm transition-all duration-200">
                        Simpan Setoran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection