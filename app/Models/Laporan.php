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

    public static function getDataLaporan() {
        $sql = "SELECT 
                    l.id, 
                    l.tanggal, 
                    petugas_user.name petugas_name, 
                    SUM(jumlah_timbangan) total_timbangan, 
                    SUM(jumlah_karyawan) total_karyawan,
                    SUM(total_blok) total_blok
                FROM laporan l
                LEFT JOIN
                (
                    SELECT 
                        h.timbangan_id,
                        SUM(h.jumlah) jumlah_timbangan, 
                        SUM(hk.jumlah_karyawan) jumlah_karyawan,
                        count(*) as total_blok,
                        t.laporan_id 
                    FROM hasil h 
                    LEFT JOIN (
                        SELECT hasil_id, count(*) jumlah_karyawan 
                        FROM hasil_has_karyawan hhk 
                        GROUP BY hasil_id
                    ) hk on hk.hasil_id = h.id
                    LEFT JOIN timbangan t ON t.id = h.timbangan_id
                    GROUP BY h.timbangan_id 
                ) AS tn ON tn.laporan_id = l.id
                LEFT JOIN users petugas_user ON petugas_user.id = l.petugas_id 
                GROUP BY l.id
                ORDER BY l.tanggal";
        return DB::select($sql);
    }
}
