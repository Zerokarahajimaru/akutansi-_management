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
            $table->string('ID_Pemasok')->index();
            $table->foreign('ID_Pemasok')->references('ID_Pemasok')->on('pemasoks')->onDelete('cascade');
            $table->string('ID_Barang')->index();
            $table->foreign('ID_Barang')->references('ID_Barang')->on('data_barangs')->onDelete('cascade');
            $table->uuid('user_id')->nullable()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->date('Tgl_Pembelian')->index();
            $table->integer('Kuantitas');
            $table->string('Jenis_Pembayaran');
            $table->decimal('Total_Harga_Barang', 15, 2);
            $table->decimal('Ongkir', 15, 2);
            $table->decimal('Total_Harga', 15, 2);
            $table->timestamps();
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
