<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Models\SundaySchoolClass;
use Illuminate\Http\Request;

class SundaySchoolClassController extends Controller
{
    // 1. Menampilkan daftar kelas
    public function index()
    {
        $classes = SundaySchoolClass::paginate(3);
        return view('sundayclasses.index', compact('classes'));
    }

    // 2. Menampilkan form untuk membuat kelas baru
    public function create()
    {
        return view('sundayclasses.add');
    }

    // 3. Menyimpan kelas baru ke database
    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        SundaySchoolClass::create([
            'name'                  => $request->input('name'),
            'description'           => $request->input('description'),
            'status'                => 'Active',
        ]);

        return redirect()->route('sunday-classes.index')->with('success', 'Data Berhasil Disimpan!');
    }

    // 4. Menampilkan detail kelas (opsional)
    public function show($encryptedId)
    {
        $id = decrypt($encryptedId);
        $class = SundaySchoolClass::findOrFail($id);
        return view('sundayclasses.show', compact('class'));
    }

    // 5. Menampilkan form untuk mengedit kelas
    public function edit($encryptedId)
    {
        $id = decrypt($encryptedId);
        $class = SundaySchoolClass::findOrFail($id);
        return view('sundayclasses.edit', compact('class'));
    }

    // 6. Memperbarui data kelas
    public function update(Request $request, $encryptedId)
    {
        $id = decrypt($encryptedId);
        $request->validate([
            'name'              => 'required|string|max:255',
            'description'       => 'nullable|string',
            'status'            => 'required|in:Active,Inactive',
        ]);

        $class = SundaySchoolClass::findOrFail($id);
        $class->update([
            'name'              => $request->input('name'),
            'description'       => $request->input('description'),
            'status'            => $request->input('status'),
        ]);

        return redirect()->route('sunday-classes.index')->with('success', 'Data Berhasil Diperbarui!');
    }

    // 7. Menghapus kelas
    public function destroy($encryptedId)
    {
        $id = decrypt($encryptedId);
        $class = SundaySchoolClass::findOrFail($id);
        $class->delete();

        return redirect()->route('sundayclasses.index')->with('success', 'Data Berhasil Dihapus!');
    }
}