<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    const KARYAWAN_HARIAN_TETAP = 'Karyawan Harian Tetap';
    const KARYAWAN_HARIAN_LEPAS = 'Karyawan Harian Lepas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'golongan_id',
        'jenis_karyawan',
        'jenis_pemanen',
        'tempat_lahir',
        'tanggal_lahir',
        'no_handphone',
        'alamat',
        'profile_picture'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function golongan() {
        return $this->belongsTo(Golongan::class, 'golongan_id', 'id');
    }

    public function karyawan() {
        return $this->belongsToMany(User::class, 'mandor_has_karyawan', 'mandor_id', 'karyawan_id');
    }

    public function mandor() {
        return $this->belongsToMany(User::class, 'mandor_has_karyawan', 'karyawan_id', 'mandor_id');
    }

    public static function jenis_pemanen()
    {
        return [
            'PM',
            'PG',
            'OS'
        ];
    }
}
