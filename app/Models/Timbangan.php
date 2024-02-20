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

    public function hasil() {
        return $this->hasOne(Hasil::class, 'timbangan_id', 'id');
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

    public static function getDataByMandor($laporan_id, $mandor_id) {
        

        return DB::table((new self())->table.' as t')
                        ->select(
                            DB::raw("t.order, 
                                    IF(SUM(h.jumlah) IS NULL, 0, SUM(h.jumlah)) AS total_timbangan, 
                                    IF(SUM(h.luas_areal) IS NULL, 0, SUM(h.luas_areal)) AS total_luas,
                                    COUNT(user_id) AS total_karyawan,
                                    (SELECT COUNT(*) from hasil as hasil_select WHERE hasil_select.timbangan_id = t.id) as total_blok"
                        ))
                        ->leftJoin('hasil as h', 'h.timbangan_id', '=', 't.id')
                        ->leftJoin('hasil_has_karyawan as hhk', 'h.id', '=', 'hhk.hasil_id')
                        ->where('t.laporan_id', $laporan_id)
                        ->where('h.mandor_id', $mandor_id)
                        ->groupBy('t.id')
                        ->get();
    }

    public static function daun($laporan_id, $mandor_id) {
        return Timbangan::with(['hasil' => function ($query) use ($mandor_id) {
                $query->where('mandor_id', $mandor_id);
            }])
            ->select('timbangan.*')
            ->selectRaw('IFNULL(SUM(hasil.jumlah), 0) as total_timbangan')
            ->selectRaw('IFNULL(SUM(hasil.luas_areal), 0) as total_luas')
            ->selectRaw('COUNT(DISTINCT hasil_has_karyawan.user_id) as total_karyawan')
            ->selectSub(function ($query) {
                $query->selectRaw('COUNT(*)')
                    ->from('hasil')
                    ->whereColumn('hasil.timbangan_id', 'timbangan.id')
                    ->groupBy('hasil.timbangan_id')
                    ->limit(1);
            }, 'total_blok')
            ->leftJoin('hasil', 'hasil.timbangan_id', '=', 'timbangan.id')
            ->leftJoin('hasil_has_karyawan', 'hasil.id', '=', 'hasil_has_karyawan.hasil_id')
            ->leftJoin('users', 'users.id', '=', 'hasil_has_karyawan.user_id')
            ->where('timbangan.laporan_id', $laporan_id)
            ->where('hasil.mandor_id', $mandor_id)
            ->groupBy('timbangan.id')
            ->get();

    }
}
