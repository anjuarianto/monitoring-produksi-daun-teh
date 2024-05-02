<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLaporanRequest;
use App\Http\Requests\UpdateLaporanRequest;
use App\Models\Hasil;
use App\Models\Laporan;
use App\Models\Timbangan;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!Auth::user()->can('laporan-list')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat laporan');
        }

        $filter_bulan = $request->get('filter-bulan')
            ? $request->get('filter-bulan')
            : date('m');

        $filter_tahun = $request->get('filter-tahun')
            ? $request->get('filter-tahun')
            : date('Y');

        $laporans = Laporan::getDataLaporan($filter_bulan, $filter_tahun);

        return view('laporan.index', compact('laporans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->can('laporan-create')) {
            abort(403, 'Anda tidak memiliki hak akses untuk membuat laporan');
        }
        $users = User::get();

        return view('laporan.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLaporanRequest $request)
    {
        if (!Auth::user()->can('laporan-create')) {
            abort(403, 'Anda tidak memiliki hak akses untuk membuat laporan');
        }

        $laporan = Laporan::create([
            'tanggal' => $request->tanggal,
            'petugas_id' => Auth::user()->id
        ]);


        for ($i = 1; $i <= 3; $i++) {
            Timbangan::create([
                'laporan_id' => $laporan->id,
                'order' => $i,
                'waktu' => date('Y-m-d H:i:s')
            ]);
        }

        return redirect()->route('laporan.index')->withSuccess('Laporan berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(Laporan $laporan)
    {
        if (!Auth::user()->can('laporan-list')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat laporan');
        }

        $users = User::get();

        $timbangans = Timbangan::getDataByLaporanId($laporan->id);

        return view('laporan.show', compact('laporan', 'users', 'timbangans'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Laporan $laporan)
    {
        if (!Auth::user()->can('laporan-edit')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengedit laporan');
        }
        $timbangans = Timbangan::getDataByLaporanId($laporan->id);
        $users = User::get();
        return view('laporan.edit', compact('laporan', 'users', 'timbangans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLaporanRequest $request, Laporan $laporan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Laporan $laporan)
    {
        if (!Auth::user()->can('laporan-delete')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus laporan');
        }

        $laporan->delete();
        return redirect()->back()->withSuccess('Data berhasil dihapus');
    }
}
