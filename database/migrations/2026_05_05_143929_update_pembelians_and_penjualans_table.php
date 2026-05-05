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
        Schema::table('pembelians', function (Blueprint $table) {
            if (!Schema::hasColumn('pembelians', 'Ongkir')) {
                $table->decimal('Ongkir', 15, 2)->default(0)->after('Total_Harga');
            }
            if (!Schema::hasColumn('pembelians', 'Total_Harga_Barang')) {
                $table->decimal('Total_Harga_Barang', 15, 2)->default(0)->after('Kuantitas');
            }
        });

        Schema::table('penjualans', function (Blueprint $table) {
            if (!Schema::hasColumn('penjualans', 'Total_Harga')) {
                $table->decimal('Total_Harga', 15, 2)->default(0)->after('Ongkir');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembelians', function (Blueprint $table) {
            $table->dropColumn(['Ongkir', 'Total_Harga_Barang']);
        });

        Schema::table('penjualans', function (Blueprint $table) {
            $table->dropColumn(['Total_Harga']);
        });
    }
};
