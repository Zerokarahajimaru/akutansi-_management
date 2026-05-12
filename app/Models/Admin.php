<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_Admin';
    public $incrementing = false; // Disable auto-incrementing for string primary key
    protected $keyType = 'string'; // Set primary key type to string

    protected $fillable = [
        'ID_Admin',
        'Nama_Admin',
        'Alamat_Admin',
        'NoTelp_Admin',
    ];

    /**
     * Get the user associated with the admin.
     */
    public function user()
    {
        return $this->hasOne(User::class, 'ID_Admin', 'ID_Admin');
    }

    /**
     * Get the users for the admin.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'ID_Admin', 'ID_Admin');
    }

    /**
     * Get the penjualans for the admin.
     */
    public function penjualans()
    {
        return $this->hasMany(Penjualan::class, 'ID_Admin', 'ID_Admin');
    }

    /**
     * Get the stok_barangs for the admin.
     */
    public function stokBarangs()
    {
        return $this->hasMany(StokBarang::class, 'ID_Admin', 'ID_Admin');
    }
}
