@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card p-6 md:p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-emerald-600">Tambah Penjualan</h1>
            <a href="{{ route('admin.penjualan.index') }}" class="text-gray-500 hover:text-emerald-600">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
            </a>
        </div>

        <form action="{{ route('admin.penjualan.store') }}" method="POST" id="penjualanForm">
            @csrf
            <div class="mb-5">
                <label class="label">Pilih Sampah</label>
                <select name="sampah_id" id="sampah_id" class="input @error('sampah_id') border-red-500 @enderror" required>
                    <option value="">-- Pilih Sampah --</option>
                    @foreach ($sampahs as $s)
                        <option value="{{ $s->id }}" data-harga="{{ $s->jenisSampah->harga_per_kg }}">
                            {{ $s->nama }} ({{ $s->jenisSampah->nama }}) - Rp {{ number_format($s->jenisSampah->harga_per_kg, 0, ',', '.') }}/kg
                        </option>
                    @endforeach
                </select>
                @error('sampah_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label class="label">Berat (kg)</label>
                <input type="number" name="berat" id="berat" min="1" step="1" 
                       class="input @error('berat') border-red-500 @enderror" value="{{ old('berat') }}" required>
                @error('berat') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5 p-4 bg-emerald-50 dark:bg-emerald-900/30 rounded-xl border border-emerald-200 dark:border-emerald-700">
                <p class="text-sm text-gray-600 dark:text-gray-400">Total Harga:</p>
                <p id="totalHarga" class="text-2xl font-bold text-emerald-600">Rp 0</p>
            </div>

            <div class="mb-6">
                <label class="label">Tanggal</label>
                <input type="date" name="tanggal_penjualan" class="input @error('tanggal_penjualan') border-red-500 @enderror" 
                       value="{{ old('tanggal_penjualan', today()->toDateString()) }}" required>
                @error('tanggal_penjualan') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.penjualan.index') }}" class="btn-gray">Batal</a>
                <button type="submit" class="btn-emerald">Simpan</button>
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