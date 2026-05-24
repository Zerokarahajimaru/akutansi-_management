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
        Schema::create('pembelians', function (Blueprint $table) {
            $table->string('ID_Pembelian')->primary();
            $table->string('ID_Pemasok')->nullable();
            $table->string('ID_Barang');
            $table->string('user_id')->nullable(); // Changed to string for usr-xyra-00x format
            $table->date('Tgl_Pembelian');
            $table->integer('Kuantitas');
            $table->string('jenis_pembayaran')->default('Transfer');
            $table->decimal('Total_Harga_Barang', 15, 2);
            $table->decimal('Ongkir', 15, 2)->default(0);
            $table->decimal('Total_Harga', 15, 2);
            $table->timestamps();

            $table->foreign('ID_Pemasok')->references('ID_Pemasok')->on('pemasoks')->onDelete('set null');
            $table->foreign('ID_Barang')->references('ID_Barang')->on('data_barangs')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelians');
    }
};
