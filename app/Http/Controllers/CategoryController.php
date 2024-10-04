<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Category::orderBy('name', 'asc')->paginate(3);
        
        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('category.add');
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

        Category::create([
            'name'              => $request->input('name'),
            'description'       => $request->input('description'),
            'status'            => 'Active',
        ]);

        return redirect()->route('category.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $encryptedId)
    {
        //
        $id = decrypt($encryptedId);
        //get product by ID
        $category = Category::findOrFail($id);

        //render view with product
        return view('category.show', compact('category'));
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

        $category = Category::findOrFail($id);

        $category->update([
            'name'              => $request->input('name'),
            'description'       => $request->input('description'),
            'status'            => $request->input('status'),
        ]);

        return redirect()->route('category.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $encryptedId)
    {
        //
        $id = decrypt($encryptedId);
        //get product by ID
        $category = Category::findOrFail($id);

        //delete product
        $category->delete();

        //redirect to index
        return redirect()->route('category.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
