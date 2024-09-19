<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Anggota;

use Illuminate\View\View;

use Illuminate\Http\RedirectResponse;

use Spatie\Permission\Models\Role;

use App\Models\Cabang;

class AnggotaController extends Controller
{
    public function index() : View
    {   
        // Mengambil semua data anggota beserta cabang-nya menggunakan eager loading (dengan relasi cabang)
        $anggota = Anggota::with('cabang', 'role')->paginate(3);
        
        return view('anggota', compact('anggota'));
    }
    
    public function create() : View
    {   
        $cabangs = Cabang::where('status', 'aktif')->get();

        $cabangoptions = $cabangs->pluck('nama', 'id');

        $roles = Role::where('id', '!=', 1)->get();

        $rolesoptions = $roles->pluck('name', 'id');

        return view('anggota.tambah', compact('cabangoptions', 'rolesoptions'));
    }

    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'nama'         => 'required|string',
            'alamat'       => 'required|string',
            'status'       => 'required|in:Aktif,Tidak Aktif',  
        ]);

        Anggota::create([
            'nama'         => $request->input('nama'),
            'deskripsi'    => $request->input('alamat'),
            'status'       => $request->input('status'),
        ]);

        return redirect()->route('anggota.index')->with(['success' => 'Data Anggota Berhasil Disimpan!']);

    }

}
