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

    public function laporan()
    {
        return $this->belongsTo(Laporan::class, 'laporan_id', 'id');
    }

    public function hasil()
    {
        return $this->hasMany(Hasil::class, 'timbangan_id');
    }

    public function karyawan()
    {
        return $this->belongsToMany(User::class, 'hasil_has_karyawan', 'hasil_id', 'user_id',);
    }


    public static function getDataByLaporanId($laporan_id)
    {
        return self::withSum('hasil as total_kht_pg', 'jumlah_kht_pg')
            ->withSum('hasil as total_kht_pm', 'jumlah_kht_pm')
            ->withSum('hasil as total_kht_os', 'jumlah_kht_os')
            ->withSum('hasil as total_khl_pg', 'jumlah_khl_pg')
            ->withSum('hasil as total_khl_pm', 'jumlah_khl_pm')
            ->withSum('hasil as total_khl_os', 'jumlah_khl_os')
            ->withSum('hasil as total_areal_pm', 'luas_areal_pm')
            ->withSum('hasil as total_areal_pg', 'luas_areal_pg')
            ->withSum('hasil as total_areal_os', 'luas_areal_os')
            ->withCount(['karyawan as total_karyawan' => function ($query) {
                $query->select(\Illuminate\Support\Facades\DB::raw('COUNT(DISTINCT user_id)'));
            }])
            ->withCount('hasil as total_blok')
            ->where('laporan_id', $laporan_id)
            ->get();
    }

    public static function test($bulan)
    {
        $timbangan = new Timbangan();
        return [
            'luas_areal' => self::withSum('hasil as total_pm', 'luas_areal_pm')->with('laporan', 'hasil')->whereHas('laporan', function ($query) use ($bulan) {
                $query->whereMonth('tanggal', 02);
            })->get()->sum('total_pm'),
            'pemetik_kht' => $timbangan->sumKhtInMonth($bulan),
            'pemetik_khl' => $timbangan->sumKhlInMonth($bulan)
        ];
    }

    public function sumKhtInMonth($bulan)
    {
        return self::withCount(['karyawan as total_kht_pm' => function ($query) {
            $query->select(\Illuminate\Support\Facades\DB::raw('COUNT(user_id)'));
            $query->where('jenis_karyawan', User::KARYAWAN_HARIAN_TETAP);
            $query->where('jenis_pemanen', 'pm');
        }])
            ->whereHas('laporan', function ($query) use ($bulan) {
                $query->whereMonth('tanggal', $bulan);
            })->get();
    }

    public function sumKhlInMonth($bulan)
    {
        return self::withCount(['karyawan as total_karyawan' => function ($query) {
            $query->select(\Illuminate\Support\Facades\DB::raw('COUNT(DISTINCT user_id)'));
            $query->where('jenis_karyawan', User::KARYAWAN_HARIAN_LEPAS);
        }])
            ->whereHas('laporan', function ($query) use ($bulan) {
                $query->whereMonth('tanggal', $bulan);
            })->get()->sum('total_karyawan');
    }


    public static function getTimbanganAwalSampaiAkhirBulan($bulan)
    {
        return self::with('laporan')
            ->whereHas('laporan', function ($query) use ($bulan) {
                $query->whereMonth('tanggal', 02);
            })
            ->withSum('hasil as total_kht', 'jumlah_kht')
            ->withSum('hasil as total_khl', 'jumlah_khl')
            ->withSum('hasil as total_areal_pm', 'luas_areal_pm')
            ->withSum('hasil as total_areal_pg', 'luas_areal_pg')
            ->withSum('hasil as total_areal_os', 'luas_areal_os')
            ->withCount(['karyawan as total_karyawan' => function ($query) {
                $query->select(\Illuminate\Support\Facades\DB::raw('COUNT(DISTINCT user_id)'));
            }])
            ->withCount('hasil as total_blok')
            ->get();
    }

    public static function getDataByMandor($laporan_id, $mandor_id)
    {
        return DB::table((new self())->table . ' as t')
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

//    public static function daun($laporan_id, $mandor_id)
//    {
//        return Timbangan::with(['hasil' => function ($query) use ($mandor_id) {
//            $query->where('mandor_id', $mandor_id);
//        }])
//            ->select('timbangan.*')
//            ->selectRaw('hasil.jumlah_kht_pm as total_jumlah_pm')
//            ->selectRaw('hasil.luas_areal as total_luas')
//            ->selectRaw('COUNT(DISTINCT hasil_has_karyawan.user_id) as total_karyawan')
//            ->selectRaw('COUNT(DISTINCT hasil.blok_id) as total_blok')
//            ->leftJoin('hasil', 'hasil.timbangan_id', '=', 'timbangan.id')
//            ->leftJoin('hasil_has_karyawan', 'hasil.id', '=', 'hasil_has_karyawan.hasil_id')
//            ->leftJoin('users', 'users.id', '=', 'hasil_has_karyawan.user_id')
//            ->where('timbangan.laporan_id', $laporan_id)
//            ->where('hasil.mandor_id', $mandor_id)
//            ->groupBy('timbangan.id')
//            ->get();
//
//    }
//
//    public static function daunTotal($laporan_id, $mandor_id): array
//    {
//        $data = self::daun($laporan_id, $mandor_id);
//        dd($data);
//
//        return [
//            'timbangan' => $data->sum('total_timbangan'),
//            'luas' => $data->sum('total_luas'),
//            'karyawan' => $data->sum('total_karyawan'),
//            'blok' => $data->sum('total_blok')
//        ];
//    }
}
