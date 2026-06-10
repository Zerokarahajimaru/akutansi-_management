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
        Schema::create('stok_adjustments', function (Blueprint $table) {
            $table->string('ID_Adjustment')->primary();
            $table->string('ID_Stok');
            $table->foreign('ID_Stok')->references('ID_Stok')->on('stok_barangs')->onDelete('cascade');
            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('Tipe'); // Masuk / Keluar
            $table->integer('Kuantitas');
            $table->string('Keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_adjustments');
    }
};
