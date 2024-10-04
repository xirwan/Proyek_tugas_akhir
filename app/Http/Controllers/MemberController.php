<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Member;
use App\Models\Branch;
use App\Models\Position;

class MemberController extends Controller
{
    public function index() : View
    {   
        // Mengambil semua data anggota beserta cabang-nya menggunakan eager loading (dengan relasi cabang)
        $members = Member::with('branch', 'role', 'user', 'position')->paginate(3);
        
        return view('member.index', compact('members'));
    }
    
    public function create() : View
    {   
        $branches = Branch::where('status', 'Active')->get();

        $branchoptions = $branches->pluck('name', 'id');

        $roles = Role::where('id', '!=', 1)->get();

        $roleoptions = $roles->pluck('name', 'id');

        $positions = Position::where('status', 'Active')->get();

        $positionoptions = $positions->pluck('name', 'id');

        return view('member.add', compact('branchoptions', 'roleoptions', 'positionoptions'));
    }

    public function store(Request $request) : RedirectResponse
    {
        // dd($request->all());
        $request->validate([
            'firstname'         => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/'],
            'lastname'          => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/'],
            'dateofbirth'       => 'required|date',
            'address'           => 'required|string',
            'role_id'           => 'required|exists:roles,id',
            'position_id'       => 'required|exists:positions,id',
            'branch_id'         => 'required|exists:branches,id',
            'email'             => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password'          => ['required', Rules\Password::defaults()],

        ], [
            'firstname.regex'       => 'Harap hanya memasukan huruf saja.',
            'lastname.regex'        => 'Harap hanya memasukan huruf saja.',
        ]);

        $fullname = $request->input('firstname') . ' ' . $request->input('lastname');

        $user = User::create([
            'email' => $request->email,
            'name'  => $fullname,
            'password' => Hash::make($request->password),
        ]);

        Member::create([
            'firstname'         => $request->input('firstname'),
            'lastname'          => $request->input('lastname'),
            'dateofbirth'       => $request->input('dateofbirth'),
            'status'            => 'Active',
            'address'           => $request->input('address'),
            'role_id'           => $request->input('role_id'),
            'position_id'       => $request->input('position_id'),
            'branch_id'         => $request->input('branch_id'),
            'user_id'           => $user->id,
        ]);
        return redirect()->route('member.index')->with(['success' => 'Data Anggota Berhasil Disimpan!']);

    }

    public function show($encryptedId): View
    {
        $id = decrypt($encryptedId);
        //get product by ID
        $member = Member::with('user')->findOrFail($id);

        $branch = Branch::where('status', 'Active')->get();

        $branchoptions = $branch->pluck('name', 'id');

        $roles = Role::where('id', '!=', 1)->get();

        $roleoptions = $roles->pluck('name', 'id');

        $positions = Position::where('status', 'Active')->get();

        $positionoptions = $positions->pluck('name', 'id');

        //render view with product
        return view('member.show', compact('member', 'branchoptions', 'roleoptions', 'positionoptions'));
    }

    public function update(Request $request, $encryptedId) : RedirectResponse
    {
        $id = decrypt($encryptedId);

        // Ambil data anggota dan user
        $member = Member::findOrFail($id);
        $user = User::findOrFail($member->user_id);
        
        $request->validate([
            'firstname'         => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/'],
            'lastname'          => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/'],
            'dateofbirth'       => 'required|date',
            'status'            => 'required|in:Active,Inactive',
            'address'           => 'required|string',
            'role_id'           => 'required|exists:roles,id',
            'position_id'       => 'required|exists:positions,id',
            'branch_id'         => 'required|exists:branches,id',
            'email'             => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],  // Pastikan email unik, kecuali untuk user saat ini
            'password'          => ['nullable', Rules\Password::defaults()],  // Password bersifat opsional saat update
        ], [
            'firstname.regex'       => 'Harap hanya memasukan huruf saja.',
            'lastname.regex'        => 'Harap hanya memasukan huruf saja.',
        ]);

        $fullname = $request->input('firstname') . ' ' . $request->input('lastname');

        // Temukan user yang terkait dengan anggota menggunakan ID
        $member = Member::findOrFail($id);
        $user = User::findOrFail($member->user_id);

        // Update data user
        $user->update([
            'email' => $request->email,
            'name'  => $fullname,
            'password' => $request->password ? Hash::make($request->password) : $user->password,  // Update password hanya jika diisi
        ]);

        // Update data anggota
        $member->update([
            'firstname'         => $request->input('firstname'),
            'lastname'          => $request->input('lastname'),
            'dateofbirth'       => $request->input('dateofbirth'),
            'status'            => $request->input('status'),
            'address'           => $request->input('address'),
            'role_id'           => $request->input('role_id'),
            'position_id'       => $request->input('position_id'),
            'branch_id'         => $request->input('branch_id'),
            'user_id'           => $user->id,
        ]);

        return redirect()->route('member.index')->with(['success' => 'Data Berhasil Diubah!']);

    }

    public function destroy($encryptedId) : RedirectResponse
    {
        $id = decrypt($encryptedId);

        // Temukan anggota berdasarkan ID
        $member = Member::findOrFail($id);

        // Temukan user yang terkait dengan anggota (melalui foreign key users_id)
        $user = User::findOrFail($member->user_id);

        // Hapus anggota
        $member->delete();

        // Hapus user yang terkait dengan anggota
        $user->delete();

        // Redirect kembali ke halaman index anggota dengan pesan sukses
        return redirect()->route('member.index')->with('success', 'Data Anggota dan Akun User berhasil dihapus!');
    }

}