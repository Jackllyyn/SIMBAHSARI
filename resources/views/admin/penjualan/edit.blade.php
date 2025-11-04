@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-xl p-6 md:p-8 border border-white/20 dark:border-gray-700/30">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold bg-gradient-to-r from-emerald-600 to-teal-500 bg-clip-text text-transparent">
                Edit Penjualan Sampah
            </h1>
            <a href="{{ route('admin.penjualan.index') }}" class="text-gray-500 hover:text-emerald-600">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
            </a>
        </div>

        <form action="{{ route('admin.penjualan.update', $penjualan) }}" method="POST" id="editForm">
            @csrf @method('PUT')

            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Pilih Sampah</label>
                <select name="sampah_id" id="sampah_id" class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-emerald-500 @error('sampah_id') border-red-500 @enderror" required>
                    <option value="">-- Pilih Sampah --</option>
                    @foreach ($sampahs as $sampah)
                        <option value="{{ $sampah->id }}" data-harga="{{ $sampah->jenisSampah->harga_per_kg }}"
                                {{ old('sampah_id', $penjualan->sampah_id) == $sampah->id ? 'selected' : '' }}>
                            {{ $sampah->nama }} ({{ $sampah->jenisSampah->nama }}) - Rp {{ number_format($sampah->jenisSampah->harga_per_kg, 0, ',', '.') }}/kg
                        </option>
                    @endforeach
                </select>
                @error('sampah_id') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Berat (kg)</label>
                <input type="number" name="berat" id="berat" min="1" step="1" 
                       value="{{ old('berat', $penjualan->berat) }}"
                       class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-emerald-500 @error('berat') border-red-500 @enderror" required>
                @error('berat') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5 p-4 bg-emerald-50 dark:bg-emerald-900/30 rounded-xl border border-emerald-200 dark:border-emerald-700">
                <p class="text-sm text-gray-600 dark:text-gray-400">Total Harga:</p>
                <p id="totalHarga" class="text-2xl font-bold text-emerald-600">Rp 0</p>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tanggal Penjualan</label>
                <input type="date" name="tanggal_penjualan" 
                       value="{{ old('tanggal_penjualan', $penjualan->tanggal_penjualan?->toDateString()) }}"
                       class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-emerald-500 @error('tanggal_penjualan') border-red-500 @enderror" required>
                @error('tanggal_penjualan') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.penjualan.index') }}" class="px-5 py-2.5 rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 transition-all">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 text-white hover:from-emerald-600 hover:to-teal-700 shadow-lg transition-all">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const sampah = document.getElementById('sampah_id');
    const berat = document.getElementById('berat');
    const totalEl = document.getElementById('totalHarga');

    function updateTotal() {
        const harga = sampah.selectedOptions[0]?.dataset.harga || 0;
        const qty = berat.value || 0;
        const total = harga * qty;
        totalEl.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
    }

    sampah.addEventListener('change', updateTotal);
    berat.addEventListener('input', updateTotal);
    updateTotal();
});
</script>
@endpush
@endsection