<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Golongan;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Models\Role as ModelsRole;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $golongans = Golongan::get();
        $roles = ModelsRole::where('name', '!=', 'Admin')->get();
        return view('auth.register', compact('golongans', 'roles'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'golongan' => ['required'],
            'role' => ['required'],
            'tempat_lahir' => ['required'],
            'jenis_karyawan' => $request->role == 'Karyawan' ? ['required'] : [],
            'jenis_pemanen' => $request->role == 'Karyawan' ? ['required'] : [],
            'tanggal' => ['required'],
            'bulan' => ['required'],
            'tahun' => ['required'],
            'no_handphone' => ['required'],
            'alamat' => ['required', 'max:255']
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'golongan_id' => $request->golongan,
            'jenis_karyawan' => $request->role == 'Karyawan' ? $request->jenis_karyawan : null,
            'jenis_pemanen' => $request->jenis_pemanen ? $request->jenis_pemanen : null,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tahun . '-' . $request->bulan . '-' . $request->tanggal,
            'no_handphone' => $request->no_handphone,
            'alamat' => $request->alamat
        ]);

        $user->assignRole([$request->role]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
