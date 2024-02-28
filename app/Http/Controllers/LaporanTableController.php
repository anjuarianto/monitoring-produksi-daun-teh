<?php

namespace App\Http\Controllers;

use App\Models\Hasil;
use App\Models\Laporan;
use App\Models\Timbangan;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class LaporanTableController extends Controller
{
    public function index(Request $request) {
        $filter_tanggal = $request->tanggal;

        if(!$filter_tanggal) {
            $filter_tanggal = date('Y-m-d');
        }

        $laporan = Laporan::where('tanggal', $filter_tanggal)->first();

        if(!$laporan) {
            return abort(404);
        }

        $timbangans = Timbangan::getDataTimbangan($laporan->id);

        if(!$timbangans) {
            return abort(404);
        }

        $hasils = Hasil::withCount(['karyawan as kht' => function($query) {
            $query->where('jenis_karyawan', 'Karyawan Harian Tetap');
        }, 'karyawan as khl' => function($query) {
            $query->where('jenis_karyawan', 'Karyawan Harian Lepas');
        }])->whereIn('timbangan_id', $timbangans->pluck('id'))->get();

        return view('laporan.table', compact('hasils', 'timbangans', 'laporan'));
    }
}
