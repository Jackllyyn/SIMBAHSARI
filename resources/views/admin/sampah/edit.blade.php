{{-- resources/views/admin/sampah/edit.blade.php --}}
@extends('layouts.app')

@section('title', $isJenis ? 'Edit Jenis Sampah' : 'Edit Sampah')

@section('content')
<div class="min-h-screen bg-gradient-to-br {{ $isJenis ? 'from-gray-50 to-blue-50' : 'from-gray-50 to-green-50' }} py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">

        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
            <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                <svg class="w-8 h-8 mr-3 {{ $isJenis ? 'text-blue-600' : 'text-green-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                {{ $isJenis ? 'Edit Jenis Sampah' : 'Edit Sampah' }}
            </h1>
        </div>

        <!-- FORM -->
        <form action="{{ $isJenis ? route('admin.sampah.updateJenis', $jenisSampah) : route('admin.sampah.update', $sampah) }}"
              method="POST" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            @csrf @method('PUT')

            <!-- NAMA -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    {{ $isJenis ? 'Nama Jenis' : 'Nama Sampah' }}
                </label>
                <input type="text"
                       name="nama"
                       value="{{ old('nama', $isJenis ? $jenisSampah->nama : $sampah->nama) }}"
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-{{ $isJenis ? 'blue' : 'green' }}-500 focus:border-{{ $isJenis ? 'blue' : 'green' }}-500 transition text-sm">
                @error('nama')
                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- HARGA PER KG (HANYA UNTUK JENIS) -->
            @if($isJenis)
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Harga per Kg</label>
                    <input type="number"
                           name="harga_per_kg"
                           step="1"
                           min="0"
                           value="{{ old('harga_per_kg', $jenisSampah->harga_per_kg) }}"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm">
                    @error('harga_per_kg')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            <!-- JENIS SAMPAH + DESKRIPSI (HANYA UNTUK SAMPAH) -->
            @if(!$isJenis)
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Sampah</label>
                    <select name="jenis_sampah_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-sm">
                        <option value="">Pilih Jenis</option>
                        @foreach ($jenisSampahs as $j)
                            <option value="{{ $j->id }}" {{ old('jenis_sampah_id', $sampah->jenis_sampah_id) == $j->id ? 'selected' : '' }}>
                                {{ $j->nama }} (Rp {{ number_format($j->harga_per_kg, 0, ',', '.') }}/kg)
                            </option>
                        @endforeach
                    </select>
                    @error('jenis_sampah_id')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="deskripsi" rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-sm">
                        {{ old('deskripsi', $sampah->deskripsi) }}
                    </textarea>
                    @error('deskripsi')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            <!-- TOMBOL -->
            <div class="flex gap-3">
                <button type="submit"
                        class="px-6 py-3 bg-{{ $isJenis ? 'blue' : 'green' }}-600 hover:bg-{{ $isJenis ? 'blue' : 'green' }}-700 text-white font-medium rounded-xl shadow-md transition">
                    {{ $isJenis ? 'Perbarui Jenis' : 'Perbarui Sampah' }}
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