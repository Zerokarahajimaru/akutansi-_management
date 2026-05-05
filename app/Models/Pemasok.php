<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemasok extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_Pemasok';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ID_Pemasok',
        'Nama_Pemasok',
        'Alamat_Pemasok',
        'NoTelp_Pemasok',
    ];

    /**
     * Get the data barangs for the pemasok.
     */
    public function dataBarangs()
    {
        return $this->hasMany(DataBarang::class, 'ID_Pemasok', 'ID_Pemasok');
    }

    /**
     * Get the pembelians for the pemasok.
     */
    public function pembelians()
    {
        return $this->hasMany(Pembelian::class, 'ID_Pemasok', 'ID_Pemasok');
    }

    /**
     * Get the stok barangs for the pemasok.
     */
    public function stokBarangs()
    {
        return $this->hasMany(StokBarang::class, 'ID_Pemasok', 'ID_Pemasok');
    }
}
