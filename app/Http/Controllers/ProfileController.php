<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
        // $user = $request->user();

        // if ($user->hasRole('Jemaat')) {
        //     return view('profile.useredit', [
        //         'user' => $user,
        //     ]);
        // } else {
        //     return view('profile.edit', [
        //         'user' => $user,
        //     ]);
        // }
    }

    public function useredit(Request $request): View
    {
        return view('profile.useredit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with(['success' => 'Data Berhasil Diubah!']);
        // ->with('status', 'profile-updated');
    }

    // public function userupdate(ProfileUpdateRequest $request): RedirectResponse
    // {
    //     $request->user()->fill($request->validated());

    //     if ($request->user()->isDirty('email')) {
    //         $request->user()->email_verified_at = null;
    //     }

    //     $request->user()->save();

    //     return Redirect::route('userprofile.edit')->with(['success' => 'Data Berhasil Diubah!']);
    // }
    

    public function userupdate(Request $request): RedirectResponse
    {
        // Validasi input
        $validated = $request->validate([
            'firstname' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'], // Hanya huruf dan spasi
            'lastname' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],  // Hanya huruf dan spasi
            'address' => ['required', 'string', 'max:255'],
            'dateofbirth' => ['required', 'date'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)->ignore($request->user()->id)],
        ], [
            'firstname.required' => 'Nama depan wajib diisi.',
            'firstname.regex' => 'Nama depan hanya boleh mengandung huruf dan spasi.',
            'lastname.required' => 'Nama belakang wajib diisi.',
            'lastname.regex' => 'Nama belakang hanya boleh mengandung huruf dan spasi.',
            'address.required' => 'Alamat wajib diisi.',
            'dateofbirth.required' => 'Tanggal lahir wajib diisi.',
            'dateofbirth.date' => 'Format tanggal lahir tidak valid.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan.',
        ]);

        // Update tabel users
        $user = $request->user();
        $user->fill([
            'email' => $validated['email'],
            'name' => $validated['firstname'] . ' ' . $validated['lastname'], // Gabungan nama depan dan belakang
        ]);

        // Jika email berubah, reset verifikasi
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Update tabel members (orang tua)
        $member = $user->member; // Pastikan ada relasi user ke member
        if ($member) {
            $member->update([
                'firstname' => $validated['firstname'],
                'lastname' => $validated['lastname'],
                'address' => $validated['address'],
                'dateofbirth' => $validated['dateofbirth'],
            ]);

            // Update alamat anak-anak yang terhubung dengan orang tua ini
            foreach ($member->children as $child) {
                $child->update([
                    'address' => $validated['address'], // Alamat anak mengikuti alamat orang tua
                ]);
            }
        }

        return Redirect::route('userprofile.edit')->with(['success' => 'Data Berhasil Diubah!']);
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
