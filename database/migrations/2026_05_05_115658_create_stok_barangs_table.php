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
            $table->uuid('user_id')->nullable()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->string('ID_Pemasok')->index();
            $table->foreign('ID_Pemasok')->references('ID_Pemasok')->on('pemasoks')->onDelete('cascade');
            $table->string('ID_Barang')->index();
            $table->foreign('ID_Barang')->references('ID_Barang')->on('data_barangs')->onDelete('cascade');
            $table->integer('Stok_Awal');
            $table->integer('Stok_Akhir')->index();
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
