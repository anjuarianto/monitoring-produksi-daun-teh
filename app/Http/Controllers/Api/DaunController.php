<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hasil;
use App\Models\Laporan;
use App\Models\Timbangan;
use App\Models\User;
use Illuminate\Http\Request;

class DaunController extends Controller
{
    public function get()
    {

        $mandor = User::find(request()->get('mandor_id'));

        if (request()->get('mandor_id')) {
            $list = Hasil::with('laporan', 'karyawans', 'blok')
                ->withCount('karyawans as total_karyawan')
                ->whereHas('laporan', function ($query) {
                    $query->where('laporan.id', request()->get('laporan_id'));
                })
                ->where('mandor_id', request()->get('mandor_id'))
                ->get();
        } else {
            $list = [];
        }

        $total = [
            'timbangan' => $list->sum('jumlah_kht_pm') + $list->sum('jumlah_kht_pg') + $list->sum('jumlah_kht_os') + $list->sum('jumlah_khl_pm') + $list->sum('jumlah_khl_pg') + $list->sum('jumlah_khl_os'),
            'luas' => $list->sum('luas_areal_pm') + $list->sum('luas_areal_pg') + $list->sum('luas_areal_os'),
            'karyawan' => $list->sum('total_karyawan'),
            'blok' => $list->count()
        ];


        return response()->json([
            'component' => [
                'body' => view('daun.component.timbangan-body', compact('list', 'mandor'))->render(),
                'footer' => view('daun.component.timbangan-footer', compact('total', 'mandor'))->render(),
            ]
        ]);
    }
}
