<?php

namespace App\Http\Controllers;

use App\Models\Hasil;
use App\Models\Laporan;
use App\Models\Timbangan;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class LaporanTableController extends Controller
{
    public function index(Request $request)
    {
        $filter_tanggal = $request->tanggal;

        if (!$filter_tanggal) {
            $filter_tanggal = date('Y-m-d');
        }

        $laporan = Laporan::where('tanggal', $filter_tanggal)->first();

        if (!$laporan) {
            return abort(404);
        }

        $timbangans = Timbangan::getDataByLaporanId($laporan->id);
        $timbangan_bulanan = Laporan::getDataBulanIni(date('m', strtotime($filter_tanggal)));
        $total_timbangan_pabrik = Timbangan::with('laporan')
            ->whereHas('laporan', function ($query) use ($filter_tanggal) {
                $query->whereMonth('tanggal', date('m', strtotime($filter_tanggal)));
            })
            ->sum('timbangan_pabrik');
        $total_timbangan = Timbangan::with('laporan')
            ->withSum('hasil as total_kht_pg', 'jumlah_kht_pg')
            ->withSum('hasil as total_kht_pm', 'jumlah_kht_pm')
            ->withSum('hasil as total_kht_os', 'jumlah_kht_os')
            ->whereHas('laporan', function ($query) use ($filter_tanggal) {
                $query->whereMonth('tanggal', date('m', strtotime($filter_tanggal)));
            })
            ->get();

        $total_bulanan = [
            'total_timbangan' => $total_timbangan->sum('total_kht_pg') + $total_timbangan->sum('total_kht_pm') + $total_timbangan->sum('total_kht_os'),
            'total_timbangan_pabrik' => $total_timbangan_pabrik,
        ];

        if (!$timbangans) {
            return abort(404);
        }

        $hasils = Hasil::withCount(['karyawans as kht' => function ($query) {
            $query->where('jenis_karyawan', 'Karyawan Harian Tetap');
        }, 'karyawans as khl' => function ($query) {
            $query->where('jenis_karyawan', 'Karyawan Harian Lepas');
        }])->whereIn('timbangan_id', $timbangans->pluck('id'))->get();

        return view('laporan.table', compact('hasils', 'timbangans', 'laporan', 'timbangan_bulanan', 'total_bulanan'));
    }
}
