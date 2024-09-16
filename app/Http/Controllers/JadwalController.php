<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Jadwal;

use Illuminate\View\View;

use Illuminate\Http\RedirectResponse;

class JadwalController extends Controller
{
    //
    public function index() : View
    {   
        // $jadwal = Jadwal::orderBy('nama', 'asc')->paginate(3);

        $jadwal = Jadwal::orderByRaw("
            CASE 
                WHEN hari = 'Senin' THEN 1
                WHEN hari = 'Selasa' THEN 2
                WHEN hari = 'Rabu' THEN 3
                WHEN hari = 'Kamis' THEN 4
                WHEN hari = 'Jumat' THEN 5
                WHEN hari = 'Sabtu' THEN 6
                WHEN hari = 'Minggu' THEN 7
            END
        ")->paginate(3);

        return view('jadwal', compact('jadwal'));

    }

    public function create() : View
    {
        return view('jadwal.tambah');
    }

    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'nama'         => 'required|string',
            'deskripsi'    => 'required|string',
            'hari'         => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
        ]);

        Jadwal::create([
            'nama'         => $request->input('nama'),
            'deskripsi'    => $request->input('deskripsi'),
            'hari'         => $request->input('hari'),
        ]);

        return redirect()->route('jadwal.index')->with(['success' => 'Data Berhasil Disimpan!']);

    }

    public function show($encryptedId) : View
    {  
        $id = decrypt($encryptedId);

        $jadwal = Jadwal::findOrFail($id);

        $haripilih = [
            'Senin' => 'Senin',
            'Selasa' => 'Selasa',
            'Rabu' => 'Rabu',
            'Kamis' => 'Kamis',
            'Jumat' => 'Jumat',
            'Sabtu' => 'Sabtu',
            'Minggu' => 'Minggu'
        ];

        //render view with product
        return view('jadwal.tampil', compact('jadwal', 'haripilih'));
    }

    public function update(Request $request, $encryptedId) : RedirectResponse
    {
        $id = decrypt($encryptedId);
        
        $request->validate([
            'nama'         => 'required|string',
            'deskripsi'    => 'required|string',
            'hari'         => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
        ]);

        $jadwal = Jadwal::findOrFail($id);

        $jadwal->update([
            'nama'         => $request->input('nama'),
            'deskripsi'    => $request->input('deskripsi'),
            'hari'         => $request->input('hari'),
        ]);

        return redirect()->route('jadwal.index')->with(['success' => 'Data Berhasil Diubah!']);

    }

    public function destroy($encryptedId): RedirectResponse
    {
        $id = decrypt($encryptedId);
        //get product by ID
        $jadwal = Jadwal::findOrFail($id);

        //delete product
        $jadwal->delete();

        //redirect to index
        return redirect()->route('jadwal.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }

}
