<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\GeneratesSequentialId;

class DataBarang extends Model
{
    use HasFactory, GeneratesSequentialId;

    protected $primaryKey = 'ID_Barang';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ID_Barang',
        'ID_Pemasok',
        'Jenis_Barang',
        'Nama_Barang',
        'Warna_Barang',
        'Ukuran_Barang',
        'Harga_Beli',
        'Harga_Jual',
    ];

    public function pemasok()
    {
        return $this->belongsTo(Pemasok::class, 'ID_Pemasok', 'ID_Pemasok');
    }

    public function penjualans()
    {
        return $this->hasMany(Penjualan::class, 'ID_Barang', 'ID_Barang');
    }

    public function pembelians()
    {
        return $this->hasMany(Pembelian::class, 'ID_Barang', 'ID_Barang');
    }

    public function stokBarangs()
    {
        return $this->hasMany(StokBarang::class, 'ID_Barang', 'ID_Barang');
    }
}
