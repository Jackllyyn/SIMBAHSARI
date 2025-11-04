@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold bg-gradient-to-r from-emerald-600 to-teal-500 bg-clip-text text-transparent">
                Penjualan Sampah
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400">Kelola transaksi penjualan</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.penjualan.create') }}" class="btn-primary">
                <i data-lucide="plus"></i> Tambah
            </a>
            <a href="{{ route('admin.penjualan.pdf') }}" class="btn-red">
                <i data-lucide="file-down"></i> PDF
            </a>
            <a href="{{ route('admin.penjualan.excel') }}" class="btn-green">
                <i data-lucide="file-spreadsheet"></i> Excel
            </a>
        </div>
    </div>

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="toast-success">
            <i data-lucide="check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <form method="GET" class="card p-5">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <input type="text" name="search" placeholder="Cari sampah..." value="{{ request('search') }}" class="input">
            <input type="date" name="start_date" value="{{ request('start_date') }}" class="input">
            <input type="date" name="end_date" value="{{ request('end_date') }}" class="input">
        </div>
        <div class="mt-4 flex gap-2">
            <button type="submit" class="btn-emerald"><i data-lucide="filter"></i> Filter</button>
            <a href="{{ route('admin.penjualan.index') }}" class="btn-gray">Reset</a>
        </div>
    </form>

    <div class="card p-6">
        <h3 class="text-lg font-semibold mb-4">Grafik Penjualan (12 Bulan)</h3>
        <canvas id="salesChart" height="100"></canvas>
    </div>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/30 dark:to-teal-900/30">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-emerald-700 dark:text-emerald-300 uppercase">Sampah</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-emerald-700 dark:text-emerald-300 uppercase">Berat</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-emerald-700 dark:text-emerald-300 uppercase">Harga</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-emerald-700 dark:text-emerald-300 uppercase">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-emerald-700 dark:text-emerald-300 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($penjualanSampahs as $p)
                        <tr class="hover:bg-emerald-50/50 dark:hover:bg-emerald-900/20">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                                <div class="flex items-center gap-2">
                                    <i data-lucide="package" class="w-4 h-4 text-gray-500"></i>
                                    {{ $p->sampah->nama }}
                                    <span class="text-xs text-gray-500">({{ $p->sampah->jenisSampah->nama }})</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                <i data-lucide="weight" class="inline w-4 h-4 mr-1 text-gray-500"></i>
                                {{ $p->berat }} kg
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-emerald-700 dark:text-emerald-300">
                                Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                <i data-lucide="calendar" class="inline w-4 h-4 mr-1 text-gray-500"></i>
                                {{ $p->tanggal_penjualan->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('admin.penjualan.edit', $p) }}" class="text-emerald-600 hover:text-emerald-700">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </a>
                                    <form id="delete-form-{{ $p->id }}" action="{{ route('admin.penjualan.destroy', $p) }}" method="POST" class="hidden">
                                        @csrf @method('DELETE')
                                    </form>
                                    <button onclick="confirmDelete({{ $p->id }})" class="text-red-600 hover:text-red-700">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-12 text-gray-500">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Grafik
    new Chart(document.getElementById('salesChart'), {
        type: 'line',
        data: {
            labels: @json($chartData['labels']),
            datasets: [{
                label: 'Penjualan (Rp)',
                data: @json($chartData['values']),
                borderColor: 'rgb(52, 211, 153)',
                backgroundColor: 'rgba(52, 211, 153, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: { responsive: true, plugins: { legend: { position: 'top' } } }
    });

    // Hapus dengan AJAX + Toast Saldo
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus?',
            text: "Data akan hilang permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then(result => {
            if (result.isConfirmed) {
                const form = document.getElementById('delete-form-' + id);
                fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        form.closest('tr').remove();
                        Swal.fire({
                            toast: true,
                            position: 'bottom-end',
                            icon: 'success',
                            title: 'Berhasil dihapus!',
                            text: `Saldo sekarang: Rp ${new Intl.NumberFormat('id-ID').format(data.saldo_update)}`,
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                            background: '#d1fae5',
                            color: '#047857',
                            iconColor: '#047857'
                        });
                    }
                })
                .catch(() => {
                    Swal.fire('Error!', 'Gagal menghapus data.', 'error');
                });
            }
        });
    }

    // Toast saldo setelah tambah/edit (via redirect)
    @if (session('saldo_update'))
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                toast: true,
                position: 'bottom-end',
                icon: 'success',
                title: 'Saldo Diperbarui!',
                text: 'Total: Rp {{ number_format(session('saldo_update'), 0, ',', '.') }}',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                background: '#d1fae5',
                color: '#047857',
                iconColor: '#047857'
            });
        });
    @endif
</script>
@endpush
@endsection