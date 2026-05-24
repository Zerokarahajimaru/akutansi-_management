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
        Schema::create('pemasoks', function (Blueprint $table) {
            $table->string('ID_Pemasok')->primary();
            $table->string('id_pemasok')->nullable(); // Required by client
            $table->string('Nama_Pemasok');
            $table->text('Alamat_Pemasok');
            $table->string('NoTelp_Pemasok');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemasoks');
    }
};
