{{-- resources/views/admin/penarikans/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tarik Saldo Nasabah')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-red-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">

        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 flex items-center">
                <svg class="w-8 h-8 mr-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                </svg>
                Tarik Saldo Nasabah
            </h1>
            <p class="text-sm text-gray-600 mt-1">Proses penarikan saldo dari nasabah ke bank</p>
        </div>

        <!-- Info Saldo Bank -->
        <div class="bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 rounded-2xl p-5 mb-8">
            <p class="text-sm font-medium text-red-800">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
                <strong>Saldo Bank Saat Ini:</strong>
                <span class="font-bold text-red-700 text-lg">
                    Rp {{ number_format($bankSaldo, 0, ',', '.') }}
                </span>
            </p>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.penarikans.store') }}" method="POST" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            @csrf

            <!-- Nasabah -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Nasabah</label>
                <select name="nasabah_id" required 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition text-sm">
                    <option value="">-- Pilih Nasabah --</option>
                    @foreach($nasabahs as $n)
                        <option value="{{ $n->id }}">
                            {{ $n->nama }} → Saldo: Rp {{ number_format($n->saldo, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
                @error('nasabah_id')
                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jumlah -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Penarikan (Rp)</label>
                <input type="number" name="jumlah" min="1" step="1" required
                       placeholder="50000"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition text-sm">
                @error('jumlah')
                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol -->
            <div class="flex gap-3">
                <button type="submit"
                        class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-xl shadow-md transition">
                    Proses Penarikan
                </button>
                <a href="{{ route('admin.penarikans.index') }}"
                   class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection