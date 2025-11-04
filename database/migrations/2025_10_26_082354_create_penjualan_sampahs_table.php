<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('penjualan_sampahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sampah_id')->constrained()->onDelete('cascade');
            $table->decimal('berat', 8, 2);
            $table->decimal('total_harga', 10, 2);
            $table->date('tanggal_penjualan');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('penjualan_sampahs');
    }
};
