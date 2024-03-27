<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Laporan;

class Timbangan extends Model
{
    use HasFactory;

    protected $table = 'timbangan';

    protected $fillable = ['laporan_id', 'order', 'waktu', 'timbangan_pabrik'];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class, 'laporan_id', 'id');
    }

    public function hasil()
    {
        return $this->hasMany(Hasil::class, 'timbangan_id');
    }

    public function karyawans()
    {
        return $this->hasManyThrough(HasilHasKaryawan::class, Hasil::class, 'timbangan_id', 'hasil_id');
    }


    public static function getDataByLaporanId($laporan_id)
    {
        return self::withSum('hasil as total_kht_pg', 'jumlah_kht_pg')
            ->withSum('hasil as total_kht_pm', 'jumlah_kht_pm')
            ->withSum('hasil as total_kht_os', 'jumlah_kht_os')
            ->withSum('hasil as total_kht_lt', 'jumlah_kht_lt')
            ->withSum('hasil as total_khl_pg', 'jumlah_khl_pg')
            ->withSum('hasil as total_khl_pm', 'jumlah_khl_pm')
            ->withSum('hasil as total_khl_os', 'jumlah_khl_os')
            ->withSum('hasil as total_khl_lt', 'jumlah_khl_lt')
            ->withSum('hasil as total_areal_pm', 'luas_areal_pm')
            ->withSum('hasil as total_areal_pg', 'luas_areal_pg')
            ->withSum('hasil as total_areal_os', 'luas_areal_os')
            ->withSum('hasil as total_areal_lt', 'luas_areal_lt')
            ->withCount(['karyawans as total_karyawan'])
            ->withCount('hasil as total_blok')
            ->where('laporan_id', $laporan_id)
            ->get();
    }

}
