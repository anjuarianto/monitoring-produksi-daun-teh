<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Golongan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $golongans = Golongan::all();

        return view('profile.edit', [
            'golongans' => $golongans,
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->update([
            'name' => $request->name,
            'golongan_id' => $request->golongan_id,
            'jenis_karyawan' => $request->jenis_karyawan,
            'jenis_pemanen' => $request->jenis_pemanen,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tahun .'-'. $request->bulan .'-'. $request->tanggal,
            'no_handphone' => $request->no_handphone,
            'alamat' => $request->alamat
        ]);

        if ($request->hasFile('profile_picture')) {
            $request->user()->update([
                'profile_picture' => $request->file('profile_picture')->store('profile-pictures', 'public'),
            ]);
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
