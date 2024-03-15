<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

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

    public function mandor()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function karyawan()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function getDataAbsenKaryawan($data)
    {
        $sql = "SELECT a.tanggal, ak.timbangan_1, ak.timbangan_2, ak.timbangan_3, ak.user_id, u.name
                FROM (
                    SELECT last_day(?) - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY as tanggal
                    FROM (
                        SELECT 0 AS a UNION ALL select 1 UNION ALL select 2 UNION ALL select 3 UNION ALL select 4 UNION ALL select 5 UNION ALL select 6 UNION ALL select 7 UNION ALL select 8 UNION ALL SELECT 9) AS a
                            ,(SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b
                            ,(SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS c
                        ) AS a
                LEFT JOIN (SELECT * FROM absen_karyawan ak WHERE user_id = ?) ak ON ak.tanggal = a.tanggal
                LEFT JOIN users AS u ON u.id = ak.created_by
                WHERE  a.tanggal BETWEEN ? AND last_day(?) ORDER BY a.tanggal";

        return DB::select($sql, array($data['first_date'], $data['user_id'], $data['first_date'], $data['first_date']));
    }

    public static function getTotalAbsen($absens)
    {
        $total = [
            'hadir' => 0,
            'izin' => 0,
            'tanpa_keterangan' => 0
        ];

        foreach ($absens as $absen) {
            $total['hadir'] += ($absen->timbangan_1 == self::HADIR) + ($absen->timbangan_2 == self::HADIR) + ($absen->timbangan_3 == self::HADIR);
            $total['izin'] += ($absen->timbangan_1 == self::IZIN) + ($absen->timbangan_2 == self::IZIN) + ($absen->timbangan_3 == self::IZIN);
            $total['tanpa_keterangan'] += ($absen->timbangan_1 == self::TANPA_KETERANGAN) + ($absen->timbangan_2 == self::TANPA_KETERANGAN) + ($absen->timbangan_3 == self::TANPA_KETERANGAN);
        }

        return $total;
    }
}
