<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGolonganRequest;
use App\Http\Requests\UpdateGolonganRequest;
use App\Models\Golongan;

class GolonganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $golongans = Golongan::get();
        return view('golongan.index', compact('golongans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('golongan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGolonganRequest $request)
    {
        Golongan::create([
            'name' => $request->name
        ]);

        return redirect()->route('golongan.index')->withSuccess('Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(Golongan $golongan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Golongan $golongan)
    {
        return view('golongan.edit', compact('golongan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGolonganRequest $request, Golongan $golongan)
    {
        $golongan->update([
            'name' => $request->name
        ]);

        return redirect()->route('golongan.index')->withSuccess('Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Golongan $golongan)
    {
        $golongan->delete();

        return redirect()->route('golongan.index')->withSuccess('Data berhasil dihapus');
    }
}
