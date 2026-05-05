<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_barangs', function (Blueprint $table) {
            $table->string('ID_Barang')->primary();
            $table->string('ID_Pemasok');
            $table->foreign('ID_Pemasok')->references('ID_Pemasok')->on('pemasoks')->onDelete('cascade');
            $table->string('Jenis_Barang');
            $table->string('Nama_Barang');
            $table->string('Warna_Barang');
            $table->string('Ukuran_Barang');
            $table->decimal('Harga_Beli', 15, 2);
            $table->decimal('Harga_Jual', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_barangs');
    }
};
