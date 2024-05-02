<?php

namespace App\Http\Controllers;

use App\Models\Hasil;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class DashboardController extends Controller
{
    //

    public function index()
    {
        if (!Auth::user()->hasRole('Admin')) {
            $user = User::find(Auth::user()->id);
            return view('dashboard.karyawan', compact('user'));
        }
        $users['total'] = User::count();

        $karyawan = [
            'total' => User::role('Karyawan')->count(),
            'KHT' => User::role('Karyawan')->where('jenis_karyawan', 'Karyawan Harian Tetap')->count(),
            'KHL' => User::role('Karyawan')->where('jenis_karyawan', 'Karyawan Harian Lepas')->count()
        ];

        $hasils = Hasil::all();
        $hasil_kemarin = Hasil::with('laporan')
            ->whereHas('laporan', function ($query) {
                $query->whereDate('tanggal', date('Y-m-d', strtotime('-1 day')));
            })
            ->get();

        $daun = [
            'total' => $hasils->sum('jumlah_kht_pm') + $hasils->sum('jumlah_kht_pg') + $hasils->sum('jumlah_kht_os') + $hasils->sum('jumlah_khl_pm') + $hasils->sum('jumlah_khl_pg') + $hasils->sum('jumlah_khl_os'),
            'kemarin' => $hasil_kemarin->sum('jumlah_kht_pm') + $hasil_kemarin->sum('jumlah_kht_pg') + $hasil_kemarin->sum('jumlah_kht_os') + $hasil_kemarin->sum('jumlah_khl_pm') + $hasil_kemarin->sum('jumlah_khl_pg') + $hasil_kemarin->sum('jumlah_khl_os'),
        ];

        return view('dashboard.admin', compact(
            'users', 'karyawan', 'daun'
        ));
    }
}
