<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Baptist;

class BaptistController extends Controller
{
    //
    public function index()
    {
        $baptists = Baptist::paginate(3);
        return view('baptist.index', compact('baptists'));
    }

    public function create()
    {
        return view('baptist.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        Baptist::create([
            'date'              => $request->input('date'),
            'description'       => $request->input('description'),
            'status'            => 'Active',
        ]);

        return redirect()->route('baptist.index')->with('success', 'Acara baptis berhasil ditambahkan.');
    }

    public function show($encryptedId)
    {
        $id = decrypt($encryptedId);
        $baptist = Baptist::findOrFail($id);
        return view('baptist.show', compact('baptist'));
    }

    public function update(Request $request, $encryptedId)
    {
        $id = decrypt($encryptedId);
        
        $request->validate([
            'date'          => 'required|date',
            'description'   => 'nullable|string',
            'status'        => 'required|in:Active,Inactive',
        ]);
        
        $baptist = Baptist::findOrFail($id);

        $baptist->update($request->all());

        return redirect()->route('baptist.index')->with('success', 'Acara baptis berhasil diperbarui.');
    }

    public function destroy(Baptist $baptist)
    {
        $baptist->delete();
        return redirect()->route('baptist.index')->with('success', 'Acara baptis berhasil dihapus.');
    }
}
