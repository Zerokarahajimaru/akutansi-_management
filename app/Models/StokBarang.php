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
        'user_id',
        'ID_Pemasok',
        'ID_Barang',
        'Stok_Awal',
        'Stok_Akhir',
        'Keterangan',
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
