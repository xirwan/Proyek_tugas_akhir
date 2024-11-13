<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BaptistClass;
use App\Models\Baptist;

class BaptistClassesController extends Controller
{
    public function index()
    {
        $classes = BaptistClass::with('baptist')->paginate(10); 
        return view('baptistclasses.index', compact('classes'));
    }

    public function create()
    {
        $baptists = Baptist::where('status', 'Active')->get();
        $baptistoptions = $baptists->pluck('date', 'id');
        return view('baptistclasses.add', compact('baptistoptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
                'id_baptist'  => 'required|exists:baptists,id',
            'day'         => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'start'       => 'required',
            'end'         => 'required',
            'description' => 'nullable|string',
        ]);

        BaptistClass::create([
            'id_baptist'    => $request->input('id_baptist'),
            'day'           => $request->input('day'),
            'start'         => $request->input('start'),
            'end'           => $request->input('end'),
            'description'   => $request->input('description'),
            'status'        => 'Active',
        ]);

        return redirect()->route('baptist-classes.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function show($encryptedId)
    {
        $id = decrypt($encryptedId);
        $baptistclass = BaptistClass::findOrFail($id);
        $baptists = Baptist::where('status', 'Active')->get();
        $baptistoptions = $baptists->pluck('date', 'id');

        $dayoptions = [
            'Senin' => 'Senin',
            'Selasa' => 'Selasa',
            'Rabu' => 'Rabu',
            'Kamis' => 'Kamis',
            'Jumat' => 'Jumat',
            'Sabtu' => 'Sabtu',
            'Minggu' => 'Minggu'
        ];

        return view('baptistclasses.show', compact('baptistclass', 'baptistoptions', 'dayoptions'));
    }

    public function update(Request $request, $encryptedId)
    {
        $id = decrypt($encryptedId);

        $request->validate([
            'id_baptist' => 'required|exists:baptists,id',
            'day' => 'required|string',
            'start' => 'required',
            'end' => 'required',
            'description' => 'nullable|string',
            'status' => 'required|string',
        ]);

        $baptistclass = BaptistClass::findOrFail($id);
        $baptistclass->update($request->all());

        return redirect()->route('baptist-classes.index')->with('success', 'Kelas berhasil diperbarui.');
    }
}
