<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Hasil extends Model
{
    use HasFactory;

    protected $table = 'hasil';

    protected $fillable = ['timbangan_id', 'jumlah_kht', 'jumlah_khl', 'luas_areal', 'mandor_id', 'blok_id'];

    public function karyawan() {
        return $this->belongsToMany(User::class, 'hasil_has_karyawan', 'hasil_id', 'user_id',);
    }


    public function blok() {
        return $this->belongsTo(Blok::class, 'blok_id', 'id');
    }

    public function mandor() {
        return $this->belongsTo(User::class, 'mandor_id', 'id');
    }



    public static function getJumlahKemarin() {

        return DB::table('laporan as l')
                        ->select(
                            DB::raw("IFNULL(SUM(h.jumlah), 0) as jumlah_kemarin, l.tanggal"
                        ))
                        ->leftJoin('timbangan as t', 't.laporan_id', '=', 'l.id')
                        ->leftJoin('hasil as h', 'h.timbangan_id', '=', 't.id')
                        ->groupBy('l.tanggal')
                        ->where('l.tanggal', date('Y-m-d',strtotime("-1 days")))
                        ->first();

    }

}
