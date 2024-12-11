<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Branch;

class BranchController extends Controller
{
    //
    public function index() : View
    {   
        $branches = Branch::orderBy('name', 'asc')->paginate(3);
        
        return view('branch.index', compact('branches'));
    }

    public function create() : View
    {
        return view('branch.add');
    }

    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'name'          => 'required|string',
            'address'       => 'required|string',  
        ]);

        Branch::create([
            'name'              => $request->input('name'),
            'address'           => $request->input('address'),
            'status'            => 'Active',
        ]);

        return redirect()->route('branch.index')->with(['success' => 'Data Berhasil Disimpan!']);

    }

    public function show($encryptedId): View
    {
        $id = decrypt($encryptedId);
        //get product by ID
        $branch = Branch::findOrFail($id);

        //render view with product
        return view('branch.show', compact('branch'));
    }
    
    public function update(Request $request, $encryptedId) : RedirectResponse
    {
        $id = decrypt($encryptedId);
        
        $request->validate([
            'name'          => 'required|string',
            'address'       => 'required|string',  
            'status'        => 'required|in:Active,Inactive',  
        ]);

        $branch = Branch::findOrFail($id);

        $branch->update([
            'name'         => $request->input('name'),
            'address'      => $request->input('address'),
            'status'       => $request->input('status'),
        ]);

        return redirect()->route('branch.index')->with(['success' => 'Data Berhasil Diubah!']);

    }

    public function destroy($encryptedId): RedirectResponse
    {
        $id = decrypt($encryptedId);
        
        // Temukan branch berdasarkan ID
        $branch = Branch::findOrFail($id);

        // Perbarui status menjadi 'Inactive' tanpa menghapus record
        $branch->update([
            'status' => 'Inactive',
        ]);

        // Redirect kembali ke index dengan pesan sukses
        return redirect()->route('branch.index')->with(['success' => 'Data Cabang berhasil di-nonaktifkan!']);
    }

    public function activate($encryptedId): RedirectResponse
    {
        $id = decrypt($encryptedId);
        
        // Temukan branch berdasarkan ID
        $branch = Branch::findOrFail($id);

        // Perbarui status menjadi 'Active'
        $branch->update([
            'status' => 'Active',
        ]);

        // Redirect kembali ke index dengan pesan sukses
        return redirect()->route('branch.index')->with(['success' => 'Data Cabang berhasil diaktifkan kembali!']);
    }


}
