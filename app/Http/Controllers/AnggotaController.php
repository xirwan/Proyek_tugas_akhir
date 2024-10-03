<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Http\RedirectResponse;

use Illuminate\View\View;

use Illuminate\Validation\Rules;

use Spatie\Permission\Models\Role;

use Illuminate\Support\Facades\Hash;

use App\Models\Anggota;

use App\Models\Cabang;

use App\Models\Position;

use App\Models\User;

class AnggotaController extends Controller
{
    public function index() : View
    {   
        // Mengambil semua data anggota beserta cabang-nya menggunakan eager loading (dengan relasi cabang)
        $anggota = Anggota::with('cabang', 'role', 'user', 'position')->paginate(3);
        
        return view('anggota', compact('anggota'));
    }
    
    public function create() : View
    {   
        $cabangs = Cabang::where('status', 'Aktif')->get();

        $cabangoptions = $cabangs->pluck('nama', 'id');

        $roles = Role::where('id', '!=', 1)->get();

        $roleoptions = $roles->pluck('name', 'id');

        $positions = Position::where('status', 'Aktif')->get();

        $positionoptions = $positions->pluck('nama', 'id');

        return view('anggota.tambah', compact('cabangoptions', 'roleoptions', 'positionoptions'));
    }

    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'namadepan'         => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/'],
            'namabelakang'      => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/'],
            'tanggal_lahir'     => 'required|date',
            'status'            => 'required|in:Aktif,Tidak Aktif',
            'deskripsi'         => 'required|string',
            'role_id'           => 'required|exists:roles,id',
            'posisi_id'         => 'required|exists:positions,id',
            'cabang_id'         => 'required|exists:cabang,id',
            // 'nama'              => 'required|string|max:255',
            'email'             => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password'          => ['required', Rules\Password::defaults()],

        ], [
            'namadepan.regex'           => 'Harap hanya memasukan huruf saja.',
            'namabelakang.regex'        => 'Harap hanya memasukan huruf saja.',
        ]);

        $namalengkap = $request->input('namadepan') . ' ' . $request->input('namabelakang');

        $user = User::create([
            'email' => $request->email,
            'name'  => $namalengkap,
            'password' => Hash::make($request->password),
        ]);

        Anggota::create([
            'nama_depan'        => $request->input('namadepan'),
            'nama_belakang'     => $request->input('namabelakang'),
            'tanggal_lahir'     => $request->input('tanggal_lahir'),
            'status'            => $request->input('status'),
            'deskripsi'         => $request->input('deskripsi'),
            'roles_id'          => $request->input('role_id'),
            'positions_id'      => $request->input('posisi_id'),
            'cabang_id'         => $request->input('cabang_id'),
            'users_id'          => $user->id,
        ]);
        return redirect()->route('anggota.index')->with(['success' => 'Data Anggota Berhasil Disimpan!']);

    }

    public function show($encryptedId): View
    {
        $id = decrypt($encryptedId);
        //get product by ID
        $anggotas = Anggota::with('user')->findOrFail($id);

        $cabangs = Cabang::where('status', 'Aktif')->get();

        $cabangoptions = $cabangs->pluck('nama', 'id');

        $roles = Role::where('id', '!=', 1)->get();

        $roleoptions = $roles->pluck('name', 'id');

        $positions = Position::where('status', 'Aktif')->get();

        $positionoptions = $positions->pluck('nama', 'id');

        //render view with product
        return view('anggota.tampil', compact('anggotas', 'cabangoptions', 'roleoptions', 'positionoptions'));
    }

    public function update(Request $request, $encryptedId) : RedirectResponse
    {
        $id = decrypt($encryptedId);

        // Ambil data anggota dan user
        $anggota = Anggota::findOrFail($id);
        $user = User::findOrFail($anggota->users_id);
        
        $request->validate([
            'namadepan'         => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/'],
            'namabelakang'      => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/'],
            'tanggal_lahir'     => 'required|date',
            'status'            => 'required|in:Aktif,Tidak Aktif',
            'deskripsi'         => 'required|string',
            'role_id'           => 'required|exists:roles,id',
            'posisi_id'         => 'required|exists:positions,id',
            'cabang_id'         => 'required|exists:cabang,id',
            'nama'              => 'required|string|max:255',
            'email'             => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],  // Pastikan email unik, kecuali untuk user saat ini
            'password'          => ['nullable', Rules\Password::defaults()],  // Password bersifat opsional saat update
        ]);

        // Temukan user yang terkait dengan anggota menggunakan ID
        $anggota = Anggota::findOrFail($id);
        $user = User::findOrFail($anggota->users_id);

        // Update data user
        $user->update([
            'email' => $request->email,
            'name'  => $request->nama,
            'password' => $request->password ? Hash::make($request->password) : $user->password,  // Update password hanya jika diisi
        ]);

        // Update data anggota
        $anggota->update([
            'nama_depan'        => $request->input('namadepan'),
            'nama_belakang'     => $request->input('namabelakang'),
            'tanggal_lahir'     => $request->input('tanggal_lahir'),
            'status'            => $request->input('status'),
            'deskripsi'         => $request->input('deskripsi'),
            'roles_id'          => $request->input('role_id'),
            'positions_id'      => $request->input('posisi_id'),
            'cabang_id'         => $request->input('cabang_id'),
        ]);

        return redirect()->route('anggota.index')->with(['success' => 'Data Berhasil Diubah!']);

    }

    public function destroy($encryptedid) : RedirectResponse
    {
        $id = decrypt($encryptedid);

        // Temukan anggota berdasarkan ID
        $anggota = Anggota::findOrFail($id);

        // Temukan user yang terkait dengan anggota (melalui foreign key users_id)
        $user = User::findOrFail($anggota->users_id);

        // Hapus anggota
        $anggota->delete();

        // Hapus user yang terkait dengan anggota
        $user->delete();

        // Redirect kembali ke halaman index anggota dengan pesan sukses
        return redirect()->route('anggota.index')->with('success', 'Data Anggota dan Akun User berhasil dihapus!');
    }

}