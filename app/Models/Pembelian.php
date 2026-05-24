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
        'user_id',
        'Tgl_Pembelian',
        'Kuantitas',
        'Jenis_Pembayaran',
        'Total_Harga_Barang',
        'Ongkir',
        'Total_Harga',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pemasok()
    {
        return $this->belongsTo(Pemasok::class, 'ID_Pemasok', 'ID_Pemasok');
    }

    public function dataBarang()
    {
        return $this->belongsTo(DataBarang::class, 'ID_Barang', 'ID_Barang');
    }
}
