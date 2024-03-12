<?php

namespace App\Http\Controllers;

use App\Models\AbsenKaryawan;
use App\Models\User;
use Illuminate\Http\Request;

class AbsenKaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (in_array('Karyawan', auth()->user()->roles->pluck('name')->toArray())) {
            $listAbsenKaryawan = new KaryawanAbsenListController();
            return $listAbsenKaryawan->__invoke($request);
        }

        $request->tanggal
            ? $tanggal = $request->tanggal
            : $tanggal = date('Y-m-d');

        $absens = AbsenKaryawan::where('tanggal', $tanggal)->get();

        return view('absen-karyawan.index', compact('absens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $karyawans = User::role('Karyawan')->get();

        return view('absen-karyawan.create', compact('karyawans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        foreach ($request->user_id as $key => $user) {
            AbsenKaryawan::create([
                'tanggal' => $request->tanggal,
                'user_id' => $user,
                'timbangan_1' => $request->timbangan_1[$key],
                'timbangan_2' => $request->timbangan_2[$key],
                'timbangan_3' => $request->timbangan_3[$key],
                'created_by' => auth()->user()->id
            ]);
        }

        return redirect()->route('absen-karyawan.index')->withSuccess('Data berhasil ditambah');

    }

    /**
     * Display the specified resource.
     */
    public function show(AbsenKaryawan $absenKaryawan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AbsenKaryawan $absenKaryawan)
    {
        $absen = $absenKaryawan;
        return view('absen-karyawan.edit', compact('absen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AbsenKaryawan $absenKaryawan)
    {
        $absenKaryawan->update([
            'timbangan_1' => $request->timbangan_1,
            'timbangan_2' => $request->timbangan_2,
            'timbangan_3' => $request->timbangan_3
        ]);

        return redirect()->route('absen-karyawan.index', ['tanggal' => $absenKaryawan->tanggal])->withSuccess('Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AbsenKaryawan $absenKaryawan)
    {
        $absenKaryawan->delete();

        return redirect()->back()->withSuccess('Data berhasil dihapus');
    }
}
