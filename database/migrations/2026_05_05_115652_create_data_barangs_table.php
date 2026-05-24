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
            $table->string('id_barang')->nullable(); // Required by client
            $table->string('ID_Pemasok');
            $table->string('id_pemasok')->nullable(); // Required by client
            $table->foreign('ID_Pemasok')->references('ID_Pemasok')->on('pemasoks')->onDelete('cascade');
            $table->string('Jenis_Barang');
            $table->string('Nama_Barang');
            $table->string('Warna_Barang');
            $table->string('Ukuran_Barang');
            $table->decimal('Harga_Beli', 15, 2);
            $table->decimal('Harga_Jual', 15, 2);
            $table->timestamps();
            
            // Explicitly name indexes to avoid collisions in Postgres
            $table->index('ID_Pemasok', 'idx_brg_pemasok');
            $table->index('Jenis_Barang', 'idx_brg_jenis');
            $table->index('Nama_Barang', 'idx_brg_nama');
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
