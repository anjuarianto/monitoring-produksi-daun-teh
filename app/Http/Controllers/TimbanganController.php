<?php

namespace App\Http\Controllers;

use App\Models\Timbangan;
use Illuminate\Http\Request;
use App\Models\Blok;
use App\Models\Hasil;
use App\Models\HasilHasKaryawan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TimbanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Timbangan $timbangan)
    {
        if (!Auth::user()->can('laporan-list')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat laporan');
        }

        $hasils = Hasil::where('timbangan_id', $timbangan->id)->get();
        $bloks = Blok::get();
        $karyawans = User::role('karyawan')->get();

        return view('laporan.timbangan.show', compact('timbangan', 'hasils', 'bloks', 'karyawans'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Timbangan $timbangan)
    {
        if (!Auth::user()->can('laporan-edit')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah laporan');
        }

        $karyawans = User::role('Karyawan')->get();
        $mandors = User::role('Mandor')->get();
        $bloks = Blok::get();
        $hasils = Hasil::with('karyawans', 'blok')->where('timbangan_id', $timbangan->id)->get();

        return view('laporan.timbangan.edit', compact('timbangan', 'bloks', 'karyawans', 'hasils', 'mandors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Timbangan $timbangan)
    {
        if (!Auth::user()->can('laporan-edit')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah laporan');
        }

        $timbangan->update([
            'timbangan_pabrik' => $request->timbangan_pabrik,
        ]);

        return redirect()->route('timbangan.edit', $timbangan->id)->withSuccess('Data berhasil diubah');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Timbangan $timbangan)
    {
        //
    }
}
