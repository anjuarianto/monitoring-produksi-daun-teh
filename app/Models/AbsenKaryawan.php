<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbsenKaryawan extends Model
{
    use HasFactory;

    const HADIR = 'Hadir';
    const IZIN = 'Izin';
    const TANPA_KETERANGAN = 'Tanpa Keterangan';

    public static $status_kehadiran = [
        self::HADIR,
        self::IZIN,
        self::TANPA_KETERANGAN
    ];

    protected $table = 'absen_karyawan';

    protected $fillable = [
        'tanggal', 'user_id', 'timbangan_1', 'timbangan_2', 'timbangan_3', 'created_by'
    ];

    public $timestamps = TRUE;

    public function mandor() {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function karyawan() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
