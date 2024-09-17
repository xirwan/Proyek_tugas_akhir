<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;

use Spatie\Permission\Models\Permission;

use Illuminate\View\View;

use Illuminate\Http\RedirectResponse;

class RoleController extends Controller
{
    //
    public function index()
    {
        $roles = Role::paginate(10);
        $permissions = Permission::all();

        return view('role', compact('roles', 'permissions'));
    }

    public function create() : View
    {
        return view('role.tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:roles,name'
        ]);

        Role::create(['name' => $request->nama]);

        return redirect()->route('role.index')->with('success', 'Role berhasil dibuat!');
    }

    public function show($encryptedId): View
    {
        $id = decrypt($encryptedId);
        //get product by ID
        $roles = Role::findOrFail($id);

        //render view with product
        return view('role.tampil', compact('roles'));
    }

    public function update(Request $request, $encryptedId) : RedirectResponse
    {
        $id = decrypt($encryptedId);
        
        $request->validate([
            'nama'         => 'required|unique:roles,name',

        ]);

        $roles = Role::findOrFail($id);
        
        $roles->update([
            'name'         => $request->input('nama'),
        ]);

        return redirect()->route('role.index')->with(['success' => 'Data Berhasil Diubah!']);

    }

    public function destroy($encryptedId): RedirectResponse
    {
        $id = decrypt($encryptedId);
        //get product by ID
        $roles = Role::findOrFail($id);

        //delete product
        $roles->delete();

        //redirect to index
        return redirect()->route('role.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }

}
