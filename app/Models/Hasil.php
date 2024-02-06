<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hasil extends Model
{
    use HasFactory;

    protected $table = 'hasil';

    protected $fillable = ['timbangan_id', 'jumlah', 'luas_areal', 'mandor_id', 'blok_id'];

    public function karyawan() {
        return $this->belongsToMany(User::class, 'hasil_has_karyawan', 'hasil_id', 'user_id',);
    }

    public function blok() {
        return $this->belongsTo(Blok::class, 'blok_id', 'id');
    }

    public function mandor() {
        return $this->belongsTo(User::class, 'mandor_id', 'id');
    }

}
