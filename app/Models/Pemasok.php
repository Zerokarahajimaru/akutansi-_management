<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\GeneratesSequentialId;

class Pemasok extends Model
{
    use HasFactory, GeneratesSequentialId;

    protected $primaryKey = 'ID_Pemasok';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ID_Pemasok',
        'Nama_Pemasok',
        'Alamat_Pemasok',
        'NoTelp_Pemasok',
    ];

    public function dataBarangs()
    {
        return $this->hasMany(DataBarang::class, 'ID_Pemasok', 'ID_Pemasok');
    }

    public function pembelians()
    {
        return $this->hasMany(Pembelian::class, 'ID_Pemasok', 'ID_Pemasok');
    }

    public function stokBarangs()
    {
        return $this->hasMany(StokBarang::class, 'ID_Pemasok', 'ID_Pemasok');
    }
}
