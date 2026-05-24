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
        Schema::create('penjualans', function (Blueprint $table) {
            $table->string('ID_Penjualan')->primary();
            $table->string('user_id')->nullable(); // Changed to string for usr-xyra-00x format
            $table->string('ID_Barang');
            $table->string('ID_Pelanggan')->nullable();
            $table->date('Tanggal_Penjualan');
            $table->integer('Kuantitas');
            $table->string('jenis_pembayaran')->default('Tunai');
            $table->decimal('Total_Harga_Barang', 15, 2);
            $table->decimal('Ongkir', 15, 2)->default(0);
            $table->decimal('Total_Harga', 15, 2);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('ID_Barang')->references('ID_Barang')->on('data_barangs')->onDelete('cascade');
            $table->foreign('ID_Pelanggan')->references('ID_Pelanggan')->on('pelanggans')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
