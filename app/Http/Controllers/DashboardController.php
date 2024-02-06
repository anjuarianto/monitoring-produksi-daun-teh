<?php

namespace App\Http\Controllers;

use App\Models\Hasil;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //

    public function index() {
        $users['total'] = User::count();

        $karyawan = [
            'total' => User::role('Karyawan')->count(),
            'KHT' => User::role('Karyawan')->where('jenis_karyawan', 'Karyawan Harian Tetap')->count(),
            'KHL' => User::role('Karyawan')->where('jenis_karyawan', 'Karyawan Harian Lepas')->count()
        ];

        $daun = [
            'total' => Hasil::sum('jumlah'),
            'kemarin' => Hasil::getJumlahKemarin()
        ];

        return view('dashboard', compact(
            'users', 'karyawan', 'daun'
        ));
    }
}
