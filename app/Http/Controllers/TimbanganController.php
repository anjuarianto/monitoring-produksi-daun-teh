<?php

namespace App\Http\Controllers;

use App\Models\Timbangan;
use Illuminate\Http\Request;
use App\Models\Blok;
use App\Models\Hasil;
use App\Models\HasilHasKaryawan;
use App\Models\User;

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
        $hasils = Hasil::where('timbangan_id', $timbangan->id)->get();
        $bloks = Blok::get();
        $karyawans = User::role('karyawan')->get();
        return view('laporan.timbangan.view', compact('timbangan', 'hasils', 'bloks', 'karyawans'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Timbangan $timbangan)
    {
        $karyawans = User::role('Karyawan')->get();
        $bloks = Blok::get();
        $hasils = Hasil::with('karyawan')->where('timbangan_id', $timbangan->id)->get();
        return view('laporan.timbangan.index', compact('timbangan', 'bloks', 'karyawans', 'hasils'));   
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Timbangan $timbangan)
    {
        dd($request->all());
        $hasils = Hasil::where('timbangan_id', $timbangan->id)->get();


        // Remove old record by timbangan id
        Hasil::where('timbangan_id', $timbangan->id)->delete();

        // foreach ($ as $key => $hasil) {
        //     Hasil::where()
        // }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Timbangan $timbangan)
    {
        //
    }
}
