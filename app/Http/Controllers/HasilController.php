<?php

namespace App\Http\Controllers;

use App\Models\Hasil;
use App\Models\HasilHasKaryawan;
use Illuminate\Http\Request;

class HasilController extends Controller
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
        if (Hasil::where('timbangan_id', $request->timbangan_id)->where('blok_id', $request->blok_id)->count() > 0) {
            return redirect()->back()->withErrors('Blok sudah ada');
        }

        $hasil = Hasil::create($request->except('karyawan_id'));

        foreach ($request->karyawan_id as $karyawan_id) {
            HasilHasKaryawan::create([
                'hasil_id' => $hasil->id,
                'user_id' => $karyawan_id
            ]);
        }

        return redirect()->back()->withSuccess('Data berhasil ditambah');

    }

    /**
     * Display the specified resource.
     */
    public function show(Hasil $hasil)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hasil $hasil)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hasil $hasil)
    {
        $hasil->update($request->except('karyawan_id'));

        HasilHasKaryawan::where('hasil_id', $hasil->id)->delete();
        foreach ($request->karyawan_id as $karyawan) {
            HasilHasKaryawan::create([
                'hasil_id' => $hasil->id,
                'user_id' => $karyawan
            ]);
        }

        return redirect()->back()->withSuccess('Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hasil $hasil)
    {
        $hasil->delete();
        return redirect()->back()->withSuccess('Data berhasil dihapus');
    }
}
