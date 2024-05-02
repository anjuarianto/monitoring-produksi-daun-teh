<?php

namespace App\Http\Controllers;

use App\Models\Golongan;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $karyawans = User::role('Karyawan')->get();
        return view('karyawan.index', compact('karyawans'));
    }

    public function show($user_id)
    {
        if (!Auth::user()->can('karyawan-list')) {
            return abort(403);
        }

        $user = User::find($user_id);

        if (!$user) {
            return abort(404);
        }

        $golongans = Golongan::get();
        $jenis_pemanens = User::jenis_pemanen();

        return view('karyawan.show', compact('user', 'golongans', 'jenis_pemanens'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($user_id)
    {
        if (!Auth::user()->can('karyawan-list')) {
            return abort(403);
        }

        $user = User::find($user_id);

        if (!$user) {
            return abort(404);
        }

        $golongans = Golongan::get();
        $jenis_pemanens = User::jenis_pemanen();

        return view('karyawan.edit', compact('user', 'golongans', 'jenis_pemanens'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $user->update([
            'jenis_karyawan' => $request->jenis_karyawan,
            'jenis_pemanen' => $request->jenis_pemanen
        ]);

        return redirect()->route('karyawan.index')->withSuccess('Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);

        $user->delete();

        return redirect()->route('karyawan.index')->withSuccess('Data berhasil dihapus');
    }
}
