<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Baptist;
use App\Models\BaptistClass;
use App\Models\Member;
class MemberBaptistController extends Controller
{
    public function index()
    {
        // Ambil semua data baptist
        $baptists = Baptist::all();
        
        // Inisialisasi $baptistClasses sebagai koleksi kosong
        $baptistClasses = collect([]);
        
        return view('memberbaptist.index', compact('baptists', 'baptistClasses'));
    }

    public function getBaptistClasses($encryptedId)
    {
        $baptistId = decrypt($encryptedId);
        // Ambil semua baptists untuk dropdown
        $baptists = Baptist::all();
        
        // Ambil kelas baptist yang terkait dengan baptist tertentu
        $baptistClasses = BaptistClass::where('id_baptist', $baptistId)->get();
        
        // Kembalikan view dengan data
        return view('memberbaptist.index', compact('baptists', 'baptistClasses'));
    }
}
