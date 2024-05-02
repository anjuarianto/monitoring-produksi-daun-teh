<?php

namespace App\Http\Controllers;

use App\Models\AbsenKaryawan;
use Illuminate\Http\Request;

class KaryawanAbsenListController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if ($request->filter_tahun == null || $request->filter_bulan == null) {
            $request->filter_tahun = date('Y');
            $request->filter_bulan = date('m');
        }
        $data = [
            'first_date' => $request->filter_tahun . '-' . $request->filter_bulan . '-01',
            'user_id' => auth()->user()->id
        ];
        $absens = AbsenKaryawan::getDataAbsenKaryawan($data);
        $total_absen = AbsenKaryawan::getTotalAbsen($absens);
        return view('absen-karyawan.karyawan-list', compact('absens', 'total_absen'));
    }
}
