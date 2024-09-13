<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cabang;

use Illuminate\View\View;

use Illuminate\Http\RedirectResponse;

class CabangController extends Controller
{
    //
    public function index() : View
    {
        //get all products
        $cabangs = Cabang::orderBy('nama', 'asc')->paginate(3);

        // $cabangs = collect(); // Mengirimkan koleksi kosong

        //render view with products
        
        return view('cabang', compact('cabangs'));
    }

    public function create() : View
    {
        return view('cabang.tambah');
    }

    public function store(Request $request) : RedirectResponse
    {
        // dd('a');
        $request->validate([
            'nama'         => 'required|string',
            'alamat'       => 'required|string',
            'status'       => 'required|in:Aktif,Tidak Aktif',  
        ]);

        Cabang::create([
            'nama'         => $request->input('nama'),
            'deskripsi'    => $request->input('alamat'),
            'status'       => $request->input('status'),
        ]);

        return redirect()->route('cabang.index')->with(['success' => 'Data Berhasil Disimpan!']);

    }   
}
