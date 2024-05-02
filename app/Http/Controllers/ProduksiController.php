<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProduksiController extends Controller
{
    public function index(Request $request): View
    {
        if (!Auth::user()->can('produksi-list')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat produksi');
        }

        $filter_tahun = $request->filter_tahun ?? date('Y');
        $produksis = Laporan::getDataLaporanByYear($filter_tahun);
        return view('produksi.index', compact('produksis'));
    }


}
