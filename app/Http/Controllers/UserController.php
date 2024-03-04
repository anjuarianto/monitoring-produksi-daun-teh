<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Golongan;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:Admin']);
    }

    /**
     * Display a listing of the resource.
    */
    public function index()
    {
        if(!Auth::user()->can('user-list')) {
            return abort(403);
        }

        $users = User::with('golongan')->get();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!Auth::user()->can('user-create')) {
            return abort(403);
        }

        $golongans = Golongan::get();
        $roles = Role::get();
        $jenis_pemanens = User::jenis_pemanen();

        return view('users.create', compact('golongans', 'roles', 'jenis_pemanens'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        if(!Auth::user()->can('user-create')) {
            return abort(403);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'jenis_karyawan' => $request->role == 'Karyawan' ? $request->jenis_karyawan : null,
            'jenis_pemanen' => $request->jenis_pemanen ? $request->jenis_pemanen : null,
            'golongan_id' => $request->golongan,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tahun.'-'.$request->bulan.'-'.$request->tanggal,
            'no_handphone' => $request->no_handphone,
            'alamat' => $request->alamat
        ]);

        $user->assignRole([$request->role]);

        return redirect()->route('users.index')->withSuccess('Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if(!Auth::user()->can('user-list')) {
            return abort(403);
        }

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if(!Auth::user()->can('user-edit')) {
            return abort(403);
        }

        $roles = Role::get();
        $golongans = Golongan::get();
        $jenis_pemanens = User::jenis_pemanen();

        return view('users.edit', compact('user', 'golongans', 'roles', 'jenis_pemanens'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        if(!Auth::user()->can('user-edit')) {
            return abort(403);
        }

        $user->update([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'golongan' => $request->golongan,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tahun.'-'.$request->bulan.'-'.$request->tanggal,
            'no_handphone' => $request->no_handphone,
            'alamat' => $request->alamat
        ]);

        $user->roles()->detach();

        $user->assignRole([$request->role]);

        return redirect()->route('users.index')->withSuccess('Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if(!Auth::user()->can('user-delete')) {
            return abort(403);
        }

        $user->delete();

        return redirect()->route('users.index')
            ->withSuccess(__('Data berhasil dihapus'));
    }
}
