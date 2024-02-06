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

    protected $fillable = ['laporan_id', 'order', 'waktu'];

    public function laporan() {
        return $this->belongsTo(Laporan::class, 'laporan_id', 'id');
    }

    public static function getDataTimbangan($laporan_id) {
        

        return DB::table((new self())->table.' as t')
                        ->select(
                            DB::raw("t.*, 
                                    IF(SUM(h.jumlah) IS NULL, 0, SUM(h.jumlah)) AS total_timbangan, 
                                    IF(SUM(h.luas_areal) IS NULL, 0, SUM(h.luas_areal)) AS total_luas,
                                    COUNT(user_id) AS total_karyawan,
                                    (SELECT COUNT(*) from hasil as hasil_select WHERE hasil_select.timbangan_id = t.id) as total_blok"
                        ))
                        ->leftJoin('hasil as h', 'h.timbangan_id', '=', 't.id')
                        ->leftJoin('hasil_has_karyawan as hhk', 'h.id', '=', 'hhk.hasil_id')
                        ->where('t.laporan_id', $laporan_id)
                        ->groupBy('t.id')
                        ->get();
    }
}
