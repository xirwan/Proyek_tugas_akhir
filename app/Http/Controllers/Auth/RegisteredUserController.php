<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Branch;
use App\Models\Member;
use App\Models\Position;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {   
        // Ambil data cabang yang aktif
        $branches = Branch::where('status', 'Active')->get();
        $branchoptions = $branches->pluck('name', 'id');
        return view('auth.register', compact('branchoptions'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'firstname'         => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/'],
            'lastname'          => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/'],
            'dateofbirth'       => 'required|date',
            'address'           => 'required|string',
            'branch_id'         => 'required|exists:branches,id',
            'email'             => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password'          => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'firstname.regex'       => 'Harap hanya memasukan huruf saja.',
            'lastname.regex'        => 'Harap hanya memasukan huruf saja.',
        ]);

        $fullname = $request->firstname . ' ' . $request->lastname;
        $isYouth = $request->has('is_youth');
        $roleName = $isYouth ? 'JemaatRemaja' : 'Jemaat';
        $positionName = $isYouth ? 'Jemaat Remaja' : 'Jemaat';


        $user = User::create([
            'email' => $request->email,
            'name'  => $fullname,
            'password' => Hash::make($request->password),
        ]);

        $role = Role::where('name', $roleName)->first();
        if (!$role) {
            return redirect()->back()->withErrors('Role tidak ditemukan.');
        }

        // Dapatkan position_id berdasarkan nama "Jemaat"
        $position = Position::where('name', $positionName)->first();
        if (!$position) {
            return redirect()->back()->withErrors('Posisi tidak ditemukan.');
        }

        if ($role) {
            $user->assignRole($role); // Berikan role ke user
        }

        // Membuat data anggota di tabel members
        Member::create([
            'firstname'         => $request->firstname,
            'lastname'          => $request->lastname,
            'dateofbirth'       => $request->dateofbirth,
            'status'            => 'Active',
            'address'           => $request->address,
            'branch_id'         => $request->branch_id,
            'position_id'       => $position->id, // Isi position_id secara manual
            'user_id'           => $user->id, // Isi user_id dari user yang baru dibuat
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('portal', absolute: false));
    }
}
