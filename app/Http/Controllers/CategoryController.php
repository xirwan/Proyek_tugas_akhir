<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $filterStatus = $request->query('status');
        $query = Category::orderByRaw("FIELD(status, 'Active', 'Inactive')");
        if ($filterStatus) {
            $query->where('status', $filterStatus);
        }
        $categories = $query->paginate(10);
        
        return view('category.index', compact('categories', 'filterStatus'));
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

        if ($request->input('status') === 'Inactive' && $category->schedules()->exists()) {
            return redirect()->back()->with([
                'error' => 'Kategori Jadwal tidak dapat dinonaktifkan karena masih digunakan oleh Jadwal.'
            ]);
        }

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

        if ($category->schedules()->exists()) {
            return redirect()->back()->with([
                'error' => 'Kategori Jadwal tidak dapat dinonaktifkan karena masih digunakan oleh Jadwal.'
            ]);
        }

        $category->update([
            'status' => 'Inactive',
        ]);

        //redirect to index
        return redirect()->route('category.index')->with(['success' => 'Data Berhasil Dinonaktifkan!']);
    }

    public function activate($encryptedId): RedirectResponse
    {
        $id = decrypt($encryptedId);
        
        // Temukan branch berdasarkan ID
        $category = Category::findOrFail($id);

        // Perbarui status menjadi 'Active'
        $category->update([
            'status' => 'Active',
        ]);

        // Redirect kembali ke index dengan pesan sukses
        return redirect()->route('category.index')->with(['success' => 'Data Berhasil Diaktifkan Kembali!']);
    }

}
