<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\GeneratesSequentialId;

class StokAdjustment extends Model
{
    use HasFactory, GeneratesSequentialId;

    protected $primaryKey = 'ID_Adjustment';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ID_Adjustment',
        'ID_Stok',
        'user_id',
        'Tipe',
        'Kuantitas',
        'Keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function stokBarang()
    {
        return $this->belongsTo(StokBarang::class, 'ID_Stok', 'ID_Stok');
    }
}
