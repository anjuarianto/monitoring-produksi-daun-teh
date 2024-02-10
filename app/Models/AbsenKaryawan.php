<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsenKaryawan extends Model
{
    use HasFactory;

    protected $table = 'absen_karyawan';

    protected $fillable = [
        'tanggal', 'user_id', 'timbangan_1', 'timbangan_2', 'timbangan_3', 'created_by'
    ];
}
