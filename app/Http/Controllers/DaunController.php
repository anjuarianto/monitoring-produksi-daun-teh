<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DaunController extends Controller
{
    public function index(Request $request): \Illuminate\View\View
    {
        if (!Auth::user()->can('daun-list')) {
            abort(403);
        }
        $filter_bulan = $request->get('filter-bulan')
            ? $request->get('filter-bulan')
            : date('m');

        $filter_tahun = $request->get('filter-tahun')
            ? $request->get('filter-tahun')
            : date('Y');

        $dauns = Laporan::getDataLaporan($filter_bulan, $filter_tahun);


        return view('daun.index', compact('dauns'));
    }

    public function show($laporan_id): \Illuminate\View\View
    {
        if (!Auth::user()->can('daun-list')) {
            abort(403);
        }
        $daun = Laporan::find($laporan_id);
        $mandors = User::role('Mandor')->get();

        return view('daun.show', compact('mandors', 'laporan_id', 'daun'));
    }

}
