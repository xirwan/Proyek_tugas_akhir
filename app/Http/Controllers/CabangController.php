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
        $cabangs = Cabang::orderBy('nama', 'asc')->paginate(3);
        
        return view('cabang', compact('cabangs'));
    }

    public function create() : View
    {
        return view('cabang.tambah');
    }

    public function store(Request $request) : RedirectResponse
    {
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

    public function show($encryptedId): View
    {
        $id = decrypt($encryptedId);
        //get product by ID
        $cabangs = Cabang::findOrFail($id);

        //render view with product
        return view('cabang.tampil', compact('cabangs'));
    }
    
    public function update(Request $request, $encryptedId) : RedirectResponse
    {
        $id = decrypt($encryptedId);
        
        $request->validate([
            'nama'         => 'required|string',
            'alamat'       => 'required|string',
            'status'       => 'required|in:Aktif,Tidak Aktif',  
        ]);

        $cabangs = Cabang::findOrFail($id);

        $cabangs->update([
            'nama'         => $request->input('nama'),
            'deskripsi'    => $request->input('alamat'),
            'status'       => $request->input('status'),
        ]);

        return redirect()->route('cabang.index')->with(['success' => 'Data Berhasil Diubah!']);

    }

    public function destroy($encryptedId): RedirectResponse
    {
        $id = decrypt($encryptedId);
        //get product by ID
        $cabangs = Cabang::findOrFail($id);

        //delete product
        $cabangs->delete();

        //redirect to index
        return redirect()->route('cabang.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }

}
