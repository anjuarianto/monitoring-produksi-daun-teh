<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProduksiController extends Controller
{
    public function index(Request $request): View
    {
        $filter_tahun = $request->filter_tahun ?? date('Y');
        $produksis = Laporan::getDataLaporanByMonth($filter_tahun);
        return view('produksi.index', compact('produksis'));
    }


}
