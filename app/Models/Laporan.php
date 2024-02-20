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

    public function kerani_timbang() {
        return $this->belongsTo(User::class, 'petugas_id', 'id');
    }

    public static function getDataLaporan($filter_bulan, $filter_tahun) {
        $sql = "SELECT
                  l.id,
                  l.tanggal,
                  petugas_user.name AS petugas_name,
                  COALESCE(SUM(tn.jumlah_timbangan), 0) AS total_timbangan,
                  COALESCE(SUM(tn.jumlah_karyawan), 0) AS total_karyawan,
                  COALESCE(SUM(tn.total_blok), 0) AS total_blok
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
                  ) hk ON hk.hasil_id = h.id
                  LEFT JOIN timbangan t ON t.id = h.timbangan_id
                  GROUP BY
                    h.timbangan_id
                ) AS tn ON tn.laporan_id = l.id
                LEFT JOIN users petugas_user ON petugas_user.id = l.petugas_id
                WHERE
                  l.tanggal >= ?
                  AND l.tanggal < ?
                GROUP BY
                  l.id
                ORDER BY
                  l.tanggal";

        $startDate = date('Y-m-01', strtotime("$filter_tahun-$filter_bulan-01"));
        $endDate = date('Y-m-d', strtotime("$startDate +1 month"));

        return DB::select($sql, [$startDate, $endDate]);
    }

    public static function getDataLaporanByMonth($filter_tahun) {
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
