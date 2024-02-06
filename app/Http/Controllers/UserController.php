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
    /**
     * Display a listing of the resource.
    */
    public function index()
    {
        $users = User::with('golongan')->get();
        
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $golongans = Golongan::get();
        $roles = Role::get();
        return view('users.create', compact('golongans', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'golongan_id' => $request->golongan,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tahun.'-'.$request->bulan.'-'.$request->tanggal,
            'no_handphone' => $request->no_handphone,
            'alamat' => $request->alamat
        ]);

        $role = Role::find($request->role);

        $user->assignRole($role->name);

        return redirect()->route('users.index')->withSuccess('Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::get();
        $golongans = Golongan::get();
        return view('users.edit', compact('user', 'golongans', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        
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

        $role = Role::find($request->role);

        $user->assignRole([$role->id]);

        return redirect()->route('users.index')->withSuccess('Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->withSuccess(__('Data berhasil dihapus'));
    }
}
