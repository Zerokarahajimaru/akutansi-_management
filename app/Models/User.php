<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
        'ID_Admin',
    ];

    /**
     * Get the user's name.
     */
    public function getNameAttribute($value)
    {
        if ($value) return $value;
        return $this->admin ? $this->admin->Nama_Admin : $this->username;
    }

    /**
     * Get the admin that owns the user.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'ID_Admin', 'ID_Admin');
    }

    /**
     * Get the column name for the "remember me" token.
     */
    public function getAuthIdentifierName(): string
    {
        return 'username';
    }

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
}
