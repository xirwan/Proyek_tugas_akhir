<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $types = Type::orderBy('name', 'asc')->paginate(3);
        
        return view('type.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('type.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name'              => 'required|string',
            'description'       => 'required|string',  
        ]);

        Type::create([
            'name'              => $request->input('name'),
            'description'       => $request->input('description'),
            'status'            => 'Active',
        ]);

        return redirect()->route('type.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $encryptedId)
    {
        //
        $id = decrypt($encryptedId);
        //get product by ID
        $type = Type::findOrFail($id);

        //render view with product
        return view('type.show', compact('type'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $encryptedId)
    {
        //
        $id = decrypt($encryptedId);
        
        $request->validate([
            'name'              => 'required|string',
            'description'       => 'required|string',  
            'status'            => 'required|in:Active,Inactive',  
        ]);

        $type = Type::findOrFail($id);

        $type->update([
            'name'              => $request->input('name'),
            'description'       => $request->input('description'),
            'status'            => $request->input('status'),
        ]);

        return redirect()->route('type.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $encryptedId)
    {
        //
        $id = decrypt($encryptedId);
        //get product by ID
        $type = Type::findOrFail($id);

        //delete product
        $type->delete();

        //redirect to index
        return redirect()->route('type.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
