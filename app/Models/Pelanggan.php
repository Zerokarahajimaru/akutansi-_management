<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\GeneratesSequentialId;

class Pelanggan extends Model
{
    use HasFactory, GeneratesSequentialId;

    protected $primaryKey = 'ID_Pelanggan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ID_Pelanggan',
        'Nama_Pelanggan',
        'Alamat_Pelanggan',
        'NoTelp_Pelanggan',
    ];

    public function penjualans()
    {
        return $this->hasMany(Penjualan::class, 'ID_Pelanggan', 'ID_Pelanggan');
    }
}
