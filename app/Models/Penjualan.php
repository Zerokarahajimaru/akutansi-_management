<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_Penjualan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ID_Penjualan',
        'ID_Admin',
        'ID_Barang',
        'ID_Pelanggan',
        'Tanggal_Penjualan',
        'Jenis_Pembayaran',
        'Total_Harga_Barang',
        'Ongkir',
        'Total_Harga',
        'Kuantitas',
    ];

    /**
     * Get the admin that owns the penjualan.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'ID_Admin', 'ID_Admin');
    }

    /**
     * Get the data barang that owns the penjualan.
     */
    public function dataBarang()
    {
        return $this->belongsTo(DataBarang::class, 'ID_Barang', 'ID_Barang');
    }

    /**
     * Get the pelanggan that owns the penjualan.
     */
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'ID_Pelanggan', 'ID_Pelanggan');
    }
}
