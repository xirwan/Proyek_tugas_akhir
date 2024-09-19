<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Position;

use Illuminate\View\View;

use Illuminate\Http\RedirectResponse;

class PositionController extends Controller
{
    //
    public function index() : View
    {   
        $positions = Position::orderBy('nama', 'asc')->paginate(3);
        
        return view('posisi', compact('positions'));
    }

    public function create() : View
    {
        return view('posisi.tambah');
    }

    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'nama'         => 'required|string',
            'deskripsi'    => 'required|string',
            'status'       => 'required|in:Aktif,Tidak Aktif',  
        ]);

        Position::create([
            'nama'         => $request->input('nama'),
            'deskripsi'    => $request->input('deskripsi'),
            'status'       => $request->input('status'),
        ]);

        return redirect()->route('posisi.index')->with(['success' => 'Data Berhasil Disimpan!']);

    }

    public function show($encryptedId): View
    {
        $id = decrypt($encryptedId);
        //get product by ID
        $positions = Position::findOrFail($id);

        //render view with product
        return view('posisi.tampil', compact('positions'));
    }

    public function update(Request $request, $encryptedId) : RedirectResponse
    {
        $id = decrypt($encryptedId);
        
        $request->validate([
            'nama'         => 'required|string',
            'deskripsi'       => 'required|string',
            'status'       => 'required|in:Aktif,Tidak Aktif',  
        ]);

        $positions = Position::findOrFail($id);

        $positions->update([
            'nama'         => $request->input('nama'),
            'deskripsi'    => $request->input('deskripsi'),
            'status'       => $request->input('status'),
        ]);

        return redirect()->route('posisi.index')->with(['success' => 'Data Berhasil Diubah!']);

    }

    public function destroy($encryptedId): RedirectResponse
    {
        $id = decrypt($encryptedId);
        //get product by ID
        $positions = Position::findOrFail($id);

        //delete product
        $positions->delete();

        //redirect to index
        return redirect()->route('posisi.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }

}
