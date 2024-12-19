<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : View
    {
        //
        $filterStatus = $request->query('status');
        $query = Type::orderByRaw("FIELD(status, 'Active', 'Inactive')");
        if ($filterStatus) {
            $query->where('status', $filterStatus);
        }
        $types = $query->paginate(10);
        return view('type.index', compact('types', 'filterStatus'));
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

        if ($request->input('status') === 'Inactive' && $type->schedules()->exists()) {
            return redirect()->back()->with([
                'error' => 'Tipe Jadwal tidak dapat dinonaktifkan karena masih digunakan oleh Jadwal.'
            ]);
        }

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
    public function destroy(string $encryptedId): RedirectResponse
    {
        $id = decrypt($encryptedId);
        // Get Type by ID
        $type = Type::findOrFail($id);

        if ($type->schedules()->exists()) {
            return redirect()->back()->with([
                'error' => 'Tipe Jadwal tidak dapat dinonaktifkan karena masih digunakan oleh Jadwal.'
            ]);
        }

        // Update status menjadi 'Inactive'
        $type->update([
            'status' => 'Inactive',
        ]);

        // Redirect to index dengan pesan sukses
        return redirect()->route('type.index')->with(['success' => 'Data Berhasil Dinonaktifkan!']);
    }

    public function activate(string $encryptedId): RedirectResponse
    {
        $id = decrypt($encryptedId);
        // Get Type by ID
        $type = Type::findOrFail($id);

        // Update status menjadi 'Active'
        $type->update([
            'status' => 'Active',
        ]);

        // Redirect to index dengan pesan sukses
        return redirect()->route('type.index')->with(['success' => 'Data Berhasil Diaktifkan Kembali!']);
    }
}
