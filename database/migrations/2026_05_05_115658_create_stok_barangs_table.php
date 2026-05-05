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
        Schema::create('stok_barangs', function (Blueprint $table) {
            $table->string('ID_Stok')->primary();
            $table->string('ID_Admin');
            $table->foreign('ID_Admin')->references('ID_Admin')->on('admins')->onDelete('cascade');
            $table->string('ID_Pemasok');
            $table->foreign('ID_Pemasok')->references('ID_Pemasok')->on('pemasoks')->onDelete('cascade');
            $table->string('ID_Barang');
            $table->foreign('ID_Barang')->references('ID_Barang')->on('data_barangs')->onDelete('cascade');
            $table->integer('Stok_Awal');
            $table->integer('Stok_Akhir');
            $table->text('Keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_barangs');
    }
};
