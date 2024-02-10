<?php

namespace App\Http\Controllers;

use App\Models\AbsenKaryawan;
use Illuminate\Http\Request;

class AbsenKaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $absens = AbsenKaryawan::get();
        return view('absen-karyawan.index', compact('absens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

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
    public function show(AbsenKaryawan $absenKaryawan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AbsenKaryawan $absenKaryawan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AbsenKaryawan $absenKaryawan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AbsenKaryawan $absenKaryawan)
    {
        //
    }
}
