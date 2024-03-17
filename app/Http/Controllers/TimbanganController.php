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

        return view('laporan.timbangan.show', compact('timbangan', 'hasils', 'bloks', 'karyawans'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Timbangan $timbangan)
    {
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
        // Remove old record by timbangan id
        Hasil::where('timbangan_id', $timbangan->id)->delete();

        // set blok
        if (!$request->blok_id) {
            return redirect()->back()->withErrors('Data tidak boleh kosong');
        }

        if (!$request->karyawan_id) {
            return redirect()->back()->withErrors('Data karyawan tidak boleh kosong');
        }

        $timbangan->update([
            'timbangan_pabrik' => $request->timbangan_pabrik,
        ]);

        foreach ($request->blok_id as $key => $blok) {

            $hasil = Hasil::create([
                'timbangan_id' => $timbangan->id,
                'blok_id' => $request->blok_id[$key],
                'mandor_id' => $request->mandor_id[$key],
                'jumlah' => $request->jumlah[$key],
                'luas_areal' => $request->luas_areal[$key]
            ]);

            foreach ($request->karyawan_id[$key] as $key => $karyawan) {
                HasilHasKaryawan::create([
                    'hasil_id' => $hasil->id,
                    'user_id' => $karyawan
                ]);
            }
        }

        return redirect()->route('laporan.edit', $timbangan->laporan_id)->withSuccess('Data berhasil diubah');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Timbangan $timbangan)
    {
        //
    }
}
