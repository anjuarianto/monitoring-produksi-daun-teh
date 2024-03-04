<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';

    protected $fillable = ['tanggal', 'petugas_id'];

    public function kerani_timbang()
    {
        return $this->belongsTo(User::class, 'petugas_id', 'id');
    }

    public function timbangan()
    {
        return $this->hasMany(Timbangan::class, 'laporan_id');
    }

    public function hasil()
    {
        return $this->hasManyThrough(Hasil::class, Timbangan::class);
    }


    public static function getDataLaporan($filter_bulan, $filter_tahun)
    {
        return self::query()->with('kerani_timbang')
            ->withSum('hasil as total_kht', 'jumlah_kht')
            ->withSum('hasil as total_khl', 'jumlah_khl')
            ->withSum('hasil as total_areal_pm', 'luas_areal_pm')
            ->withSum('hasil as total_areal_pg', 'luas_areal_pg')
            ->withSum('hasil as total_areal_os', 'luas_areal_os')
            ->withCount(['hasil as total_blok' => function ($query) {
                $query->select(DB::raw('COUNT(DISTINCT blok_id)'));
            }])
            ->addSelect(['total_karyawan' => Hasil::selectRaw('COUNT(hasil_has_karyawan.user_id)')
                ->join('hasil_has_karyawan', 'hasil.id', '=', 'hasil_has_karyawan.hasil_id')
                ->join('timbangan', 'hasil.timbangan_id', '=', 'timbangan.id')
                ->whereColumn('timbangan.laporan_id', 'laporan.id')
                ->limit(1)
            ])
            ->whereMonth('tanggal', $filter_bulan)
            ->whereYear('tanggal', $filter_tahun)
            ->get();

    }

    public static function getDataLaporanByMonth($filter_tahun)
    {
        $sql = "
      SELECT
          m.month as bulan,
          IFNULL(t.total_timbangan, 0) AS total_timbangan,
          IFNULL(t.total_karyawan, 0) AS total_karyawan,
          IFNULL(t.total_blok, 0) AS total_blok
      FROM (
          SELECT '01' AS month UNION ALL SELECT '02' UNION ALL SELECT '03' UNION ALL SELECT '04' UNION ALL SELECT '05' UNION ALL SELECT '06'
          UNION ALL SELECT '07' UNION ALL SELECT '08' UNION ALL SELECT '09' UNION ALL
          SELECT '10' UNION ALL SELECT '11' UNION ALL SELECT '12'
      ) AS m
      LEFT JOIN (
          SELECT
              MONTH(l.tanggal) AS month,
              IFNULL(SUM(jumlah_timbangan), 0) AS total_timbangan,
              IFNULL(SUM(jumlah_karyawan), 0) AS total_karyawan,
              IFNULL(SUM(total_blok), 0) AS total_blok
          FROM
              laporan l
          LEFT JOIN (
              SELECT
                  h.timbangan_id,
                  SUM(h.jumlah) AS jumlah_timbangan,
                  SUM(hk.jumlah_karyawan) AS jumlah_karyawan,
                  COUNT(*) AS total_blok,
                  t.laporan_id
              FROM
                  hasil h
              LEFT JOIN (
                  SELECT
                      hasil_id,
                      COUNT(*) AS jumlah_karyawan
                  FROM
                      hasil_has_karyawan hhk
                  GROUP BY
                      hasil_id
              ) AS hk ON hk.hasil_id = h.id
              LEFT JOIN timbangan t ON t.id = h.timbangan_id
              GROUP BY
                  h.timbangan_id
          ) AS tn ON tn.laporan_id = l.id
          WHERE
              YEAR(l.tanggal) = ?
          GROUP BY
              MONTH(l.tanggal)
      ) AS t ON m.month = t.month
      ORDER BY
          m.month";

        return DB::select($sql, array($filter_tahun));
    }
}
