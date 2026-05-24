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
            $table->string('user_id')->nullable(); // Changed to string for usr-xyra-00x format
            $table->string('ID_Pemasok')->nullable();
            $table->string('ID_Barang');
            $table->integer('Stok_Awal')->default(0);
            $table->integer('Stok_Akhir')->default(0);
            $table->text('Keterangan')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('ID_Pemasok')->references('ID_Pemasok')->on('pemasoks')->onDelete('set null');
            $table->foreign('ID_Barang')->references('ID_Barang')->on('data_barangs')->onDelete('cascade');
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
