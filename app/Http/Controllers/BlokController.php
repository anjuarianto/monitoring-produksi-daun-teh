<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlokRequest;
use App\Http\Requests\UpdateBlokRequest;
use App\Models\Blok;

class BlokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bloks = Blok::get();
        return view('blok.index', compact('bloks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blok.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlokRequest $request)
    {
        Blok::create([
            'name' => $request->name,
            'luas_areal' => $request->luas_areal
        ]);

        return redirect()->route('blok.index')->withSuccess('Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blok $blok)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blok $blok)
    {
        return view('blok.edit', compact('blok'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlokRequest $request, Blok $blok)
    {
        $blok->update([
            'name' => $request->name,
            'luas_areal' => $request->luas_areal
        ]);

        return redirect()->route('blok.index')->withSuccess('Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blok $blok)
    {
        $blok->delete();

        return redirect()->route('blok.index');
    }
}
