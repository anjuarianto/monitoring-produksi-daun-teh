<?php

namespace App\Http\Controllers;

use App\Models\Hasil;
use App\Models\Laporan;
use App\Models\Timbangan;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class LaporanTableController extends Controller
{
    public function index()
    {
        $laporans = Laporan::get();
        return view('laporan.table.index', compact('laporans'));
    }

    public function show($id)
    {
        $laporan = Laporan::find($id);

        if (!$laporan) {
            return abort(404);
        }

        $tanggal = $laporan->tanggal;

        $timbangans = Timbangan::getDataByLaporanId($laporan->id);
        $timbangan_bulanan = Laporan::getDataBulanIni(date('m', strtotime($tanggal)));
        $total_timbangan_pabrik = Timbangan::with('laporan')
            ->whereHas('laporan', function ($query) use ($tanggal) {
                $query->whereMonth('tanggal', date('m', strtotime($tanggal)));
            })
            ->sum('timbangan_pabrik');
        $total_timbangan = Timbangan::with('laporan')
            ->withSum('hasil as total_kht_pg', 'jumlah_kht_pg')
            ->withSum('hasil as total_kht_pm', 'jumlah_kht_pm')
            ->withSum('hasil as total_kht_os', 'jumlah_kht_os')
            ->whereHas('laporan', function ($query) use ($tanggal) {
                $query->whereMonth('tanggal', date('m', strtotime($tanggal)));
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

        return view('laporan.table.show', compact('hasils', 'timbangans', 'laporan', 'timbangan_bulanan', 'total_bulanan'));
    }
}
