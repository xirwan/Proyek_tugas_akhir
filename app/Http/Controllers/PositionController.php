<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Position;

class PositionController extends Controller
{
    //
    public function index() : View
    {   
        $positions = Position::where('status', 'Active')->paginate(10);
        
        return view('position.index', compact('positions'));
    }

    public function create() : View
    {
        return view('position.add');
    }

    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'name'          => 'required|string',
            'description'   => 'required|string',  
        ]);

        Position::create([
            'name'          => $request->input('name'),
            'description'   => $request->input('description'),
            'status'        => 'Active',
        ]);

        return redirect()->route('position.index')->with(['success' => 'Data Berhasil Disimpan!']);

    }

    public function show($encryptedId): View
    {
        $id = decrypt($encryptedId);
        //get product by ID
        $positions = Position::findOrFail($id);

        //render view with product
        return view('position.show', compact('positions'));
    }

    public function update(Request $request, $encryptedId) : RedirectResponse
    {
        $id = decrypt($encryptedId);
        
        $request->validate([
            'name'          => 'required|string',
            'description'   => 'required|string',
            'status'        => 'required|in:Active,Inactive',  
        ]);

        $positions = Position::findOrFail($id);

        $positions->update([
            'name'          => $request->input('name'),
            'description'   => $request->input('description'),
            'status'        => $request->input('status'),
        ]);

        return redirect()->route('position.index')->with(['success' => 'Data Berhasil Diubah!']);

    }

    public function destroy($encryptedId): RedirectResponse
    {
        $id = decrypt($encryptedId);
        $position = Position::findOrFail($id);

        // Ubah status menjadi 'Inactive'
        $position->update([
            'status' => 'Inactive',
        ]);

        return redirect()->route('position.index')->with(['success' => 'Data Berhasil Dinonaktifkan!']);
    }

    public function activate($encryptedId): RedirectResponse
    {
        $id = decrypt($encryptedId);
        $position = Position::findOrFail($id);

        // Ubah status menjadi 'Active'
        $position->update([
            'status' => 'Active',
        ]);

        return redirect()->route('position.index')->with(['success' => 'Data Berhasil Diaktifkan Kembali!']);
    }

}