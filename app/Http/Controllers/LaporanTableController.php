<?php

namespace App\Http\Controllers;

use App\Models\Hasil;
use App\Models\HasilHasKaryawan;
use App\Models\Laporan;
use App\Models\Timbangan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LaporanTableController extends Controller
{
    public function index()
    {
        if (!Auth::user()->can('laporan-report-list')) {
            return abort(403, 'Anda tidak memiliki hak akses untuk melihat data laporan');
        }

        $laporans = Laporan::orderBy('tanggal', 'desc')->get();
        return view('laporan.table.index', compact('laporans'));
    }

    public function show($id)
    {
        if (!Auth::user()->can('laporan-report-list')) {
            return abort(403, 'Anda tidak memiliki hak akses untuk melihat data laporan');
        }

        $dataLaporan = $this->_dataExport($id);
        $hasils = $dataLaporan['hasils'];
        $timbangans = $dataLaporan['timbangans'];
        $hasilTotal = $dataLaporan['hasilTotal'];
        $laporan = $dataLaporan['laporan'];
        $hasilBulanan = $dataLaporan['hasilBulanan'];
        $total_bulanan = $dataLaporan['total_bulanan'];


        return view('laporan.table.show', compact(
                'hasils', 'timbangans', 'hasilTotal',
                'laporan', 'hasilBulanan', 'total_bulanan')
        );
    }

    public function export($id)
    {
        $dataLaporan = $this->_dataExport($id);
        $hasils = $dataLaporan['hasils'];
        $timbangans = $dataLaporan['timbangans'];
        $hasilTotal = $dataLaporan['hasilTotal'];
        $laporan = $dataLaporan['laporan'];
        $hasilBulanan = $dataLaporan['hasilBulanan'];
        $total_bulanan = $dataLaporan['total_bulanan'];

        $view = view('laporan.table.export', compact(
                'hasils', 'timbangans', 'hasilTotal',
                'laporan', 'hasilBulanan', 'total_bulanan')
        );

//        echo $view;
//        die;


        $pdf = \Spatie\Browsershot\Browsershot::html($view)
            ->userDataDir(storage_path('app/public'))
            ->setNodeBinary('c:/Program Files/nodejs/node.exe')
            ->setNpmBinary('c:/Program Files/nodejs/npm.cmd')
            ->setChromePath('c:/Program Files/Google/Chrome/Application/chrome.exe')
            ->margins(10, 10, 10, 10)
            ->windowSize(1920, 1080)
            ->paperSize(210, 297)
            ->landscape()
            ->waitUntilNetworkIdle()
            ->savePdf('cuk.pdf');

        $headers = array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="cuk-' . $laporan->tanggal . '.pdf"',
        );

//        return new Response($pdf, 200, $headers);

        return response()->download('cuk.pdf', 'laporan-' . $laporan->tanggal . '.pdf', $headers);
    }

    public function _dataExport($id)
    {
        $laporan = Laporan::find($id);

        if (!$laporan) {
            return abort(404);
        }

        $tanggal = $laporan->tanggal;

        $timbangans = Timbangan::getDataByLaporanId($laporan->id);
        $hasilBulanan = Laporan::getDataBulanIni(date(date($tanggal)));
        $hasilLeavyTea = Laporan::getDataHasilLeavyTea($laporan->id);

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

        $hasils = [];
        $hasilRegular = Laporan::getDataHasilRegular($laporan->id);

        $hasilRegular = $hasilRegular->map(function ($item) {
            return [
                'blok' => $item->blok->name,
                'luas_areal_blok' => $item->blok->luas_areal,
                'luas_areal' => $item->luas_areal,
                'pusingan_petikan_ke' => $item->pusingan_petikan_ke,
                'total_karyawan_kht' => $item->total_karyawan_kht,
                'total_karyawan_khl' => $item->total_karyawan_khl,
                'total_karyawan' => $item->total_karyawan_kht + $item->total_karyawan_khl,
                'jumlah_timbangan_kht' => $item->jumlah_timbangan_kht,
                'jumlah_timbangan_khl' => $item->jumlah_timbangan_khl,
                'total_timbangan' => $item->jumlah_timbangan_kht + $item->jumlah_timbangan_khl,
                'bulan_ini_blok' => '',
                'bulan_ini_luas_areal' => '',
                'bulan_ini_pusingan_petikan_ke' => '',
                'bulan_ini_total_karyawan_kht' => '',
                'bulan_ini_total_karyawan_khl' => '',
                'bulan_ini_total_karyawan' => '',
                'bulan_ini_jumlah_timbangan_kht' => '',
                'bulan_ini_jumlah_timbangan_khl' => '',
                'bulan_ini_total_timbangan' => ''
            ];
        });

        foreach ($hasilRegular as $key => $hasil) {
            $array_regular = [
                'blok' => $hasil['blok'],
                'luas_areal_blok' => $hasil['luas_areal_blok'],
                'luas_areal' => $hasil['luas_areal'],
                'pusingan_petikan_ke' => $hasil['pusingan_petikan_ke'],
                'total_karyawan_kht' => $hasil['total_karyawan_kht'],
                'total_karyawan_khl' => $hasil['total_karyawan_khl'],
                'total_karyawan' => $hasil['total_karyawan'],
                'jumlah_timbangan_kht' => $hasil['jumlah_timbangan_kht'],
                'jumlah_timbangan_khl' => $hasil['jumlah_timbangan_khl'],
                'total_timbangan' => $hasil['total_timbangan'],
                'bulan_ini_blok' => '',
                'bulan_ini_luas_areal' => '',
                'bulan_ini_total_karyawan_kht' => '',
                'bulan_ini_total_karyawan_khl' => '',
                'bulan_ini_total_karyawan' => '',
                'bulan_ini_jumlah_timbangan_kht' => '',
                'bulan_ini_jumlah_timbangan_khl' => '',
                'bulan_ini_total_timbangan' => ''
            ];
            array_push($hasils, $array_regular);
        }

        foreach ($hasilBulanan as $key => $bulanan) {
            if ($key != 'lt') {
                $array_bulanan = [
                    'blok' => '',
                    'luas_areal_blok' => '',
                    'luas_areal' => '',
                    'pusingan_petikan_ke' => '',
                    'total_karyawan_kht' => '',
                    'total_karyawan_khl' => '',
                    'total_karyawan' => '',
                    'jumlah_timbangan_kht' => '',
                    'jumlah_timbangan_khl' => '',
                    'total_timbangan' => '',
                    'bulan_ini_blok' => $key,
                    'bulan_ini_luas_areal' => $bulanan['luas_areal'],
                    'bulan_ini_total_karyawan_kht' => $bulanan['total_karyawan_kht'],
                    'bulan_ini_total_karyawan_khl' => $bulanan['total_karyawan_khl'],
                    'bulan_ini_total_karyawan' => (int)$bulanan['total_karyawan_kht'] + (int)$bulanan['total_karyawan_khl'],
                    'bulan_ini_jumlah_timbangan_kht' => $bulanan['total_timbangan_kht'],
                    'bulan_ini_jumlah_timbangan_khl' => $bulanan['total_timbangan_khl'],
                    'bulan_ini_total_timbangan' => $bulanan['total_timbangan_kht'] + $bulanan['total_timbangan_khl']
                ];
                array_push($hasils, $array_bulanan);

            }

        }


        foreach ($hasilLeavyTea as $key => $hasil_lt) {
            $hasilLt = [
                'blok' => $hasil_lt->blok->name,
                'luas_areal_blok' => $hasil_lt->blok->luas_areal,
                'luas_areal' => $hasil_lt->luas_areal_lt,
                'pusingan_petikan_ke' => $hasil_lt->pusingan_petikan_ke,
                'total_karyawan_kht' => '',
                'total_karyawan_khl' => '',
                'total_karyawan' => '',
                'jumlah_timbangan_kht' => $hasil_lt->jumlah_kht_lt,
                'jumlah_timbangan_khl' => $hasil_lt->jumlah_khl_lt,
                'total_timbangan' => $hasil_lt->jumlah_kht_lt + $hasil_lt->jumlah_khl_lt,
                'bulan_ini_blok' => $key == 0 ? 'LT' : '',
                'bulan_ini_luas_areal' => $key == 0 ? $hasilBulanan['lt']['luas_areal'] : '',
                'bulan_ini_total_karyawan_kht' => '',
                'bulan_ini_total_karyawan_khl' => '',
                'bulan_ini_total_karyawan' => '',
                'bulan_ini_jumlah_timbangan_kht' => $key == 0 ? $hasilBulanan['lt']['total_timbangan_kht'] : '',
                'bulan_ini_jumlah_timbangan_khl' => $key == 0 ? $hasilBulanan['lt']['total_timbangan_khl'] : '',
                'bulan_ini_total_timbangan' => $key == 0 ? $hasilBulanan['lt']['total_timbangan_kht'] + $hasilBulanan['lt']['total_timbangan_khl'] : '',
            ];
            array_push($hasils, $hasilLt);
        }

        $hasilTotal = [
            'blok' => 'JUMLAH',
            'luas_areal_blok' => '',
            'luas_areal' => $hasilRegular->sum('luas_areal'),
            'pusingan_petikan_ke' => implode('/', $hasilRegular->pluck('pusingan_petikan_ke')->toArray()),
            'total_karyawan_kht' => $hasilRegular->sum('total_karyawan_kht'),
            'total_karyawan_khl' => $hasilRegular->sum('total_karyawan_khl'),
            'total_karyawan' => $hasilRegular->sum('total_karyawan_kht') + $hasilRegular->sum('total_karyawan_khl'),
            'jumlah_timbangan_kht' => $hasilRegular->sum('jumlah_timbangan_kht') + $hasilLeavyTea->sum('jumlah_kht_lt'),
            'jumlah_timbangan_khl' => $hasilRegular->sum('jumlah_timbangan_khl') + $hasilLeavyTea->sum('jumlah_khl_lt'),
            'total_timbangan' => $hasilRegular->sum('jumlah_timbangan_kht') + $hasilLeavyTea->sum('jumlah_kht_lt') + $hasilRegular->sum('jumlah_timbangan_khl') + $hasilLeavyTea->sum('jumlah_khl_lt'),
            'bulan_ini_blok' => '',
            'bulan_ini_luas_areal' => $hasilBulanan['pm']['luas_areal'] + $hasilBulanan['pg']['luas_areal'] + $hasilBulanan['os']['luas_areal'] + $hasilBulanan['lt']['luas_areal'],
            'bulan_ini_total_karyawan_kht' => (int)$hasilBulanan['pm']['total_karyawan_kht'] + (int)$hasilBulanan['pg']['total_karyawan_kht'] + (int)$hasilBulanan['os']['total_karyawan_kht'] + (int)$hasilBulanan['lt']['total_karyawan_kht'],
            'bulan_ini_total_karyawan_khl' => (int)$hasilBulanan['pm']['total_karyawan_khl'] + (int)$hasilBulanan['pg']['total_karyawan_khl'] + (int)$hasilBulanan['os']['total_karyawan_khl'] + (int)$hasilBulanan['lt']['total_karyawan_khl'],
            'bulan_ini_total_karyawan' => (int)$hasilBulanan['pm']['total_karyawan_kht'] + (int)$hasilBulanan['pg']['total_karyawan_kht'] + (int)$hasilBulanan['os']['total_karyawan_kht'] + (int)$hasilBulanan['lt']['total_karyawan_kht'] + (int)$hasilBulanan['pm']['total_karyawan_khl'] + (int)$hasilBulanan['pg']['total_karyawan_khl'] + (int)$hasilBulanan['os']['total_karyawan_khl'] + (int)$hasilBulanan['lt']['total_karyawan_khl'],
            'bulan_ini_jumlah_timbangan_kht' => (int)$hasilBulanan['pm']['total_timbangan_kht'] + (int)$hasilBulanan['pg']['total_timbangan_kht'] + (int)$hasilBulanan['os']['total_timbangan_kht'] + (int)$hasilBulanan['lt']['total_timbangan_kht'],
            'bulan_ini_jumlah_timbangan_khl' => (int)$hasilBulanan['pm']['total_timbangan_khl'] + (int)$hasilBulanan['pg']['total_timbangan_khl'] + (int)$hasilBulanan['os']['total_timbangan_khl'] + (int)$hasilBulanan['lt']['total_timbangan_khl'],
            'bulan_ini_total_timbangan' => (int)$hasilBulanan['pm']['total_timbangan_kht'] + (int)$hasilBulanan['pg']['total_timbangan_kht'] + (int)$hasilBulanan['os']['total_timbangan_kht'] + (int)$hasilBulanan['lt']['total_timbangan_kht'] + (int)$hasilBulanan['pm']['total_timbangan_khl'] + (int)$hasilBulanan['pg']['total_timbangan_khl'] + (int)$hasilBulanan['os']['total_timbangan_khl'] + (int)$hasilBulanan['lt']['total_timbangan_khl']
        ];

        return compact(
            'hasils', 'timbangans', 'hasilTotal',
            'laporan', 'hasilBulanan', 'total_bulanan');
    }
}
