<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Hasil extends Model
{
    use HasFactory;

    protected $table = 'hasil';

    protected $fillable = [
        'laporan_id', 'timbangan_id', 'luas_areal_pm', 'luas_areal_pg', 'luas_areal_os', 'luas_areal_lt',
        'pusingan_petikan_ke',
        'jumlah_kht_pg', 'jumlah_kht_pm', 'jumlah_kht_os', 'jumlah_kht_lt',
        'jumlah_khl_pg', 'jumlah_khl_pm', 'jumlah_khl_os', 'jumlah_khl_lt',
        'mandor_id', 'blok_id'
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class, 'laporan_id');
    }


    public function karyawans()
    {
        return $this->belongsToMany(User::class, 'hasil_has_karyawan', 'hasil_id', 'user_id');
    }


    public function karyawan_kht_pm()
    {
        return $this->belongsToMany(User::class, 'hasil_has_karyawan', 'hasil_id', 'user_id',)
            ->where('jenis_karyawan', User::KARYAWAN_HARIAN_TETAP)
            ->where('jenis_pemanen', 'pm');
    }

    public function karyawan_pm()
    {
        return $this->belongsToMany(User::class, 'hasil_has_karyawan', 'hasil_id', 'user_id',)
            ->where('jenis_pemanen', 'pm');
    }


    public function blok()
    {
        return $this->belongsTo(Blok::class, 'blok_id', 'id');
    }

    public function mandor()
    {
        return $this->belongsTo(User::class, 'mandor_id', 'id');
    }

    public function timbangan()
    {
        return $this->belongsTo(Timbangan::class, 'timbangan_id', 'id');
    }


    public static function getJumlahKemarin()
    {

        return DB::table('laporan as l')
            ->select(
                DB::raw("IFNULL(SUM(h.jumlah), 0) as jumlah_kemarin, l.tanggal"
                ))
            ->leftJoin('timbangan as t', 't.laporan_id', '=', 'l.id')
            ->leftJoin('hasil as h', 'h.timbangan_id', '=', 't.id')
            ->groupBy('l.tanggal')
            ->where('l.tanggal', date('Y-m-d', strtotime("-1 days")))
            ->first();

    }

}
