<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OpsiMandorController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        if(!Auth::user()->can('opsi-mandor-list')){
            abort(403);
        }

        $mandors = \App\Models\User::role('Mandor')->get();

        return view('opsi-mandor.index', compact('mandors'));
    }

    public function edit($id): \Illuminate\View\View
    {
        if(!Auth::user()->can('opsi-mandor-edit')){
            abort(403);
        }

        $mandor = User::find($id);
        $karyawans = User::role('karyawan')->get();

        return view('opsi-mandor.edit', compact('mandor', 'karyawans'));
    }

    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        if(!Auth::user()->can('opsi-mandor-edit')){
            abort(403);
        }

        $mandor = User::find($id);

        $mandor->karyawan()->sync($request->karyawan_id);

        return redirect()->route('opsi-mandor.index')->withSuccess('Data berhasil diubah');
    }
}
