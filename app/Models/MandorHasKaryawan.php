<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MandorHasKaryawan extends Model
{
    use HasFactory;

    protected $table = 'mandor_has_karyawan';

    protected $fillable = [
        'mandor_id',
        'karyawan_id'
    ];


    public function karyawan()
    {
        return $this->belongsTo(User::class, 'karyawan_id');
    }


}
