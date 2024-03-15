<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
            ->withSum('hasil as total_kht_pg', 'jumlah_kht_pg')
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

    public static function getDataHasilRegular($laporan_id)
    {
        return Hasil::where('laporan_id', $laporan_id)
            ->groupBy('blok_id')
            ->get()
            ->map(function ($item) {
                $hasil = Hasil::where('laporan_id', $item->laporan_id)->where('blok_id', $item->blok_id);
                $item->luas_areal = $hasil->sum('luas_areal_pm') + $hasil->sum('luas_areal_pg') + $hasil->sum('luas_areal_os');
                $item->jumlah_timbangan_kht = $hasil->sum('jumlah_kht_pm') + $hasil->sum('jumlah_kht_pg') + $hasil->sum('jumlah_kht_os');
                $item->jumlah_timbangan_khl = $hasil->sum('jumlah_khl_pm') + $hasil->sum('jumlah_khl_pg') + $hasil->sum('jumlah_khl_os');
                $item->total_karyawan_kht = Hasil::where('laporan_id', $item->laporan_id)->where('blok_id', $item->blok_id)->withCount(['karyawans as kht' => function ($query) {
                    $query->where('jenis_karyawan', 'Karyawan Harian Tetap');
                }])->get()->sum('kht');
                $item->total_karyawan_khl = Hasil::where('laporan_id', $item->laporan_id)->where('blok_id', $item->blok_id)->withCount(['karyawans as khl' => function ($query) {
                    $query->where('jenis_karyawan', 'Karyawan Harian Lepas');
                }])->get()->sum('khl');
                return $item;
            });
    }

    public static function getDataHasilLeavyTea($laporan_id)
    {
        return Hasil::where('laporan_id', $laporan_id)
            ->where('jumlah_kht_lt', '>', 0)
            ->orWhere('jumlah_khl_lt', '>', 0)
            ->groupBy('blok_id')
            ->get()
            ->map(function ($item) {
                $item->total_karyawan_kht = Hasil::where('laporan_id', $item->laporan_id)->where('blok_id', $item->blok_id)->withCount(['karyawans as kht' => function ($query) {
                    $query->where('jenis_karyawan', 'Karyawan Harian Tetap');
                }])->get()->sum('kht');
                $item->total_karyawan_khl = Hasil::where('laporan_id', $item->laporan_id)->where('blok_id', $item->blok_id)->withCount(['karyawans as khl' => function ($query) {
                    $query->where('jenis_karyawan', 'Karyawan Harian Lepas');
                }])->get()->sum('khl');
                return $item;
            });
    }

    public static function getDataBulanIni($bulan)
    {
        $hasil = Hasil::whereHas('laporan', function ($query) use ($bulan) {
            $query->whereMonth('tanggal', $bulan);
        })->get();

        $karyawanPm = Hasil::withCount(['karyawans as total_karyawan_kht' => function ($query) {
            $query->where('jenis_karyawan', User::KARYAWAN_HARIAN_TETAP);
            $query->where('jenis_pemanen', 'pm');
        }])->withCount(['karyawans as total_karyawan_khl' => function ($query) {
            $query->where('jenis_karyawan', User::KARYAWAN_HARIAN_LEPAS);
            $query->where('jenis_pemanen', 'pm');
        }])->whereHas('laporan', function ($query) use ($bulan) {
            $query->whereMonth('tanggal', $bulan);
        })->get();

        $karyawanPg = Hasil::withCount(['karyawans as total_karyawan_kht' => function ($query) {
            $query->where('jenis_karyawan', User::KARYAWAN_HARIAN_TETAP);
            $query->where('jenis_pemanen', 'pg');
        }])->withCount(['karyawans as total_karyawan_khl' => function ($query) {
            $query->where('jenis_karyawan', User::KARYAWAN_HARIAN_LEPAS);
            $query->where('jenis_pemanen', 'pg');
        }])->whereHas('laporan', function ($query) use ($bulan) {
            $query->whereMonth('tanggal', $bulan);
        })->get();

        $karyawanOs = Hasil::withCount(['karyawans as total_karyawan_kht' => function ($query) {
            $query->where('jenis_karyawan', User::KARYAWAN_HARIAN_TETAP);
            $query->where('jenis_pemanen', 'os');
        }])->withCount(['karyawans as total_karyawan_khl' => function ($query) {
            $query->where('jenis_karyawan', User::KARYAWAN_HARIAN_LEPAS);
            $query->where('jenis_pemanen', 'os');
        }])->whereHas('laporan', function ($query) use ($bulan) {
            $query->whereMonth('tanggal', $bulan);
        })->get();

        return [
            'pm' => [
                'luas_areal' => $hasil->sum('luas_areal_pm'),
                'total_karyawan_kht' => $karyawanPm->sum('total_karyawan_kht'),
                'total_karyawan_khl' => $karyawanPm->sum('total_karyawan_khl'),
                'total_timbangan_kht' => $hasil->sum('jumlah_kht_pm'),
                'total_timbangan_khl' => $hasil->sum('jumlah_khl_pm')
            ],
            'pg' => [
                'luas_areal' => $hasil->sum('luas_areal_pg'),
                'total_karyawan_kht' => $karyawanPg->sum('total_karyawan_kht'),
                'total_karyawan_khl' => $karyawanPg->sum('total_karyawan_khl'),
                'total_timbangan_kht' => $hasil->sum('jumlah_kht_pg'),
                'total_timbangan_khl' => $hasil->sum('jumlah_khl_pg')
            ],
            'os' => [
                'luas_areal' => $hasil->sum('luas_areal_os'),
                'total_karyawan_kht' => $karyawanOs->sum('total_karyawan_kht'),
                'total_karyawan_khl' => $karyawanOs->sum('total_karyawan_khl'),
                'total_timbangan_kht' => $hasil->sum('jumlah_kht_os'),
                'total_timbangan_khl' => $hasil->sum('jumlah_khl_os')
            ],
            'lt' => [
                'luas_areal' => $hasil->sum('luas_areal_lt'),
                'total_karyawan_kht' => '',
                'total_karyawan_khl' => '',
                'total_timbangan_kht' => $hasil->sum('jumlah_kht_lt'),
                'total_timbangan_khl' => $hasil->sum('jumlah_khl_lt')
            ]
        ];
    }


    public static function getDataLaporanByYear($filter_tahun)
    {
        $sql = "
      SELECT
          m.month as bulan,
          IFNULL(t.jumlah_kht_pm, 0) AS total_timbangan_kht,
          IFNULL(t.jumlah_khl_pm, 0) AS total_timbangan_khl,
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
              IFNULL(SUM(jumlah_kht), 0) AS jumlah_kht_pm,
              IFNULL(SUM(jumlah_khl), 0) AS jumlah_khl_pm,
              IFNULL(SUM(jumlah_karyawan), 0) AS total_karyawan,
              IFNULL(SUM(total_blok), 0) AS total_blok
          FROM
              laporan l
          LEFT JOIN (
              SELECT
                  h.timbangan_id,
                  (SUM(h.jumlah_kht_pm) + SUM(h.jumlah_kht_pg) + SUM(h.jumlah_kht_os) + SUM(h.jumlah_kht_lt)) AS jumlah_kht,
                  (SUM(h.jumlah_khl_pm) + SUM(h.jumlah_khl_pg) + SUM(h.jumlah_khl_os) + SUM(h.jumlah_khl_lt)) AS jumlah_khl,
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


    public static function test($filter_tahun)
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
            ->whereYear('tanggal', $filter_tahun)
            ->get();

    }

}
