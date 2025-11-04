<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Admin\LaporanController;

class LaporanExport implements FromView
{
    protected $bulan, $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function view(): View
    {
        $controller = app(LaporanController::class);
        $data = $controller->getLaporanData($this->bulan, $this->tahun);
        return view('admin.laporan.excel', $data);
    }
}