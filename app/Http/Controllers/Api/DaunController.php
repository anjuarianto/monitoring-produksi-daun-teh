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
            $list = Hasil::with('laporan', 'karyawans', 'blok', 'timbangan')
                ->withCount('karyawans')
                ->whereHas('laporan', function ($query) {
                    $query->where('laporan.id', request()->get('laporan_id'));
                })
                ->where('mandor_id', request()->get('mandor_id'))
                ->get()->map(function ($item) {
                    $item->total_timbangan = $item->jumlah_kht_pm + $item->jumlah_kht_pg + $item->jumlah_kht_os + $item->jumlah_kht_lt + $item->jumlah_khl_pm + $item->jumlah_khl_pg + $item->jumlah_khl_os + $item->jumlah_khl_lt;
                    return $item;
                });
        } else {
            $list = collect([]);
        }

        $total = [
            'timbangan' => $list->sum('total_timbangan'),
            'luas' => $list->sum('luas_areal_pm') + $list->sum('luas_areal_pg') + $list->sum('luas_areal_os'),
            'karyawan' => $list->sum('karyawans_count'),
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
