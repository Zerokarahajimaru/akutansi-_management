<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\GeneratesSequentialId;

class Penjualan extends Model
{
    use HasFactory, GeneratesSequentialId;

    protected $primaryKey = 'ID_Penjualan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ID_Penjualan',
        'user_id',
        'ID_Barang',
        'ID_Pelanggan',
        'Tanggal_Penjualan',
        'Kuantitas',
        'jenis_pembayaran',
        'Total_Harga_Barang',
        'Ongkir',
        'Total_Harga',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function dataBarang()
    {
        return $this->belongsTo(DataBarang::class, 'ID_Barang', 'ID_Barang');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'ID_Pelanggan', 'ID_Pelanggan');
    }
}
