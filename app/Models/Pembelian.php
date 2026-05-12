<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_Pembelian';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ID_Pembelian',
        'ID_Pemasok',
        'ID_Barang',
        'Tgl_Pembelian',
        'Kuantitas',
        'Total_Harga_Barang',
        'Ongkir',
        'Jenis_Pembayaran',
        'Total_Harga',
    ];

    /**
     * Get the pemasok that owns the pembelian.
     */
    public function pemasok()
    {
        return $this->belongsTo(Pemasok::class, 'ID_Pemasok', 'ID_Pemasok');
    }

    /**
     * Get the data barang that owns the pembelian.
     */
    public function dataBarang()
    {
        return $this->belongsTo(DataBarang::class, 'ID_Barang', 'ID_Barang');
    }
}
