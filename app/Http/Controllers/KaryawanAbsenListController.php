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
        $data = [
            'first_date' => $request->filter_tahun.'-'.$request->filter_bulan.'-01',
            'user_id' => auth()->user()->id
        ];

        $absens = AbsenKaryawan::getDataAbsenKaryawan($data);
        return view('absen-karyawan.karyawan-list', compact('absens'));
    }
}
