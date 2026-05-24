<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use App\Traits\GeneratesSequentialId;

class User extends Authenticatable
{
    use HasFactory, Notifiable, GeneratesSequentialId;

    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();
        
        // Invalidate session cache when user updated
        static::updated(function ($user) {
            Cache::forget('user_auth_id_' . $user->id);
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'name',
        'username',
        'password',
        'role',
        'NoTelp_User',
        'Alamat_User',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function penjualans()
    {
        return $this->hasMany(Penjualan::class, 'user_id');
    }

    public function pembelians()
    {
        return $this->hasMany(Pembelian::class, 'user_id');
    }

    public function stokBarangs()
    {
        return $this->hasMany(StokBarang::class, 'user_id');
    }
}
