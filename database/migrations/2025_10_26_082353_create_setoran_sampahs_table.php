<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('setoran_sampahs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('nasabah_id')->constrained('nasabahs')->onDelete('cascade');
    $table->foreignId('sampah_id')->constrained('sampahs')->onDelete('cascade');
    $table->integer('berat'); 
    $table->integer('total_harga');
    $table->date('tanggal_setor');
    $table->timestamps();
});
    }
    public function down(): void {
        Schema::dropIfExists('setoran_sampahs');
    }
};