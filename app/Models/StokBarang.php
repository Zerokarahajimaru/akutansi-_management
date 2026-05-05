<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokBarang extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_Stok';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ID_Stok',
        'ID_Admin',
        'ID_Pemasok',
        'ID_Barang',
        'Stok_Awal',
        'Stok_Akhir',
        'Keterangan',
    ];

    /**
     * Get the admin that owns the stok barang.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'ID_Admin', 'ID_Admin');
    }

    /**
     * Get the pemasok that owns the stok barang.
     */
    public function pemasok()
    {
        return $this->belongsTo(Pemasok::class, 'ID_Pemasok', 'ID_Pemasok');
    }

    /**
     * Get the data barang that owns the stok barang.
     */
    public function dataBarang()
    {
        return $this->belongsTo(DataBarang::class, 'ID_Barang', 'ID_Barang');
    }
}
