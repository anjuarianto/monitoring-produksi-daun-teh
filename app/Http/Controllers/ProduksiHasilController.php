<?php

namespace App\Http\Controllers;

use App\Models\General;
use App\Models\Laporan;
use Illuminate\Http\Request;

class ProduksiHasilController extends Controller
{
    public function index(Request $request)
    {
        $filter_tahun = $request->filter_tahun ?? date('Y');
        $labels = General::getListBulan()->toArray();
        $labels = array_values($labels);

        $filter_tahun = $request->filter_tahun ?? date('Y');
        $produksis = collect(Laporan::getDataLaporanByYear($filter_tahun));
        $data = $produksis->map(function ($produksi) {
            return $produksi->total_timbangan_kht + $produksi->total_timbangan_khl;
        });

        return view('produksi.hasil', compact('labels', 'data'));
    }
}
