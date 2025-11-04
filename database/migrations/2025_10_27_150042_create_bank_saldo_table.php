<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bank_saldo', function (Blueprint $table) {
            $table->id();
            $table->decimal('saldo', 15, 2)->default(0);
            $table->timestamps();
        });

        // HITUNG TOTAL dari penjualan_sampahs
        $total = DB::table('penjualan_sampahs')->sum('total_harga');

        // INSERT ke bank_saldo
        DB::table('bank_saldo')->insert([
            'saldo' => $total > 0 ? $total : 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('bank_saldo');
    }
};