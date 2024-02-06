<?php

namespace App\Models;

use stdClass;

class General
{
    public static $dataTanggalString = [
        '1' => 'Senin',
        '2' => 'Selasa',
        '3' => 'Rabu',
        '4' => 'Kamis',
        '5' => 'Jumat',
        '6' => 'Sabtu',
        '7' => 'Minggu'
    ];

    public static $listBulan = [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember'
    ];

    public static function getListTanggal() {
        $collection = collect([
            1,2,3,4,5,6,7,8,9,10,
            11,12,13,14,15,16,17,18,19,20,
            21,22,23,24,25,26,27,28,29,30,31
        ]);

        return $collection;
    }

    public static function setBulanToString($bulan) {
        return self::$listBulan[$bulan];
    }

    public static function setTanggaltoString($tanggal) {
        return self::$dataTanggalString[$tanggal];
    }

    public static function getListBulan() {
        $collection = collect(self::$listBulan);

        return $collection;
    }

    public static function getListTahun() {
        $start = (int) date('Y') - 10;
        $end = 1960;

        for ($i=$start; $i >= $end; $i--) { 
            $data[] = $i;
        }

        $collection = collect($data);
        return $collection;
    } 
}
