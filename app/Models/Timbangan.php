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

    public function karyawan() {
        return $this->belongsToMany(User::class, 'hasil_has_karyawan', 'hasil_id', 'user_id',);
    }


    public static function getDataTimbangan($laporan_id) {


        return Timbangan::where('laporan_id', $laporan_id)
            ->withCount([
                'hasil as count_users' => function ($query) {
                    $query->join('hasil_has_karyawan as hhk1', 'hasil.id', '=', 'hhk1.hasil_id')
                        ->join('users as u', 'hhk1.user_id', '=', 'u.id')
                        ->select(DB::raw('COUNT(DISTINCT hhk1.user_id)'));
                },
                'hasil as count_blok' => function ($query) {
                    $query->select(DB::raw('COUNT(DISTINCT blok_id)'));
                },
                'hasil as sum_jumlah' => function ($query) {
                    $query->select(DB::raw('SUM(jumlah)'));
                }
            ])->get();
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
            ->selectRaw('hasil.jumlah as total_timbangan')
            ->selectRaw('hasil.luas_areal as total_luas')
            ->selectRaw('COUNT(DISTINCT hasil_has_karyawan.user_id) as total_karyawan')
            ->selectRaw('COUNT(DISTINCT hasil.blok_id) as total_blok')
            ->leftJoin('hasil', 'hasil.timbangan_id', '=', 'timbangan.id')
            ->leftJoin('hasil_has_karyawan', 'hasil.id', '=', 'hasil_has_karyawan.hasil_id')
            ->leftJoin('users', 'users.id', '=', 'hasil_has_karyawan.user_id')
            ->where('timbangan.laporan_id', $laporan_id)
            ->where('hasil.mandor_id', $mandor_id)
            ->groupBy('timbangan.id')
            ->get();

    }

    public static function daunTotal($laporan_id, $mandor_id): array
    {
        $data = self::daun($laporan_id, $mandor_id);

        return [
            'timbangan' => $data->sum('total_timbangan'),
            'luas' => $data->sum('total_luas'),
            'karyawan' => $data->sum('total_karyawan'),
            'blok' => $data->sum('total_blok')
        ];
    }
}
