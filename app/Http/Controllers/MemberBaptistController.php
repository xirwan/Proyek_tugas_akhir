<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Baptist;
use App\Models\MemberBaptist;
use Illuminate\Support\Facades\Auth;
use App\Models\BaptistAttendance;

class MemberBaptistController extends Controller
{
    public function index()
    {
        // Mendapatkan data baptist dengan kelas terkait beserta jamnya
        $baptists = Baptist::with(['classes' => function ($query) {
            $query->select('id', 'id_baptist', 'day', 'start', 'end'); // Pastikan kolom start dan end tersedia
        }])->get();

        // Ambil daftar kelas yang sudah didaftarkan oleh pengguna yang sedang login
        $registeredClasses = Auth::user()->member ? Auth::user()->member->memberBaptists->pluck('id_baptist_class')->toArray() : [];

        // Cek apakah user sudah mendaftar
        $isAlreadyRegistered = !empty($registeredClasses);

        return view('memberbaptist.index', compact('baptists', 'registeredClasses', 'isAlreadyRegistered'));
    }

    public function register(Request $request)
    {
        // Ambil ID dari permintaan user langsung, tanpa dekripsi
        $baptistId = $request->baptist_id;
        $baptistClassId = $request->baptist_class_id;

        // Validasi data input
        $request->validate([
            'baptist_id' => 'required',
            'baptist_class_id' => 'required',
        ]);

        // Ambil id_member dari pengguna yang sedang login
        $idMember = Auth::user()->member->id;

        // Cek apakah user sudah mendaftar di kelas baptis yang sama
        $existingRegistration = MemberBaptist::where('id_member', $idMember)
                                            ->where('id_baptist_class', $baptistClassId)
                                            ->first();

        if ($existingRegistration) {
            // Jika sudah terdaftar, redirect kembali dengan pesan error
            return redirect()->back()->with('error', 'Anda sudah terdaftar di kelas baptis ini.');
        }

        // Simpan data pendaftaran jika belum terdaftar di kelas yang sama
        MemberBaptist::create([
            'id_member' => $idMember,
            'id_baptist_class' => $baptistClassId,
        ]);

        return redirect()->route('portal')->with('success', 'Pendaftaran berhasil.');
    }

    public function showDetails()
    {
        $user = Auth::user();
        $member = $user->member;

        // Dapatkan kelas baptis yang diikuti member ini
        $memberBaptist = MemberBaptist::with(['baptistClass.details'])->where('id_member', $member->id)->first();

        if (!$memberBaptist) {
            return redirect()->back()->with('error', 'Anda belum terdaftar di kelas baptis.');
        }

        $class = $memberBaptist->baptistClass;
        $details = $class->details()->paginate(10);

        // Mengambil kehadiran untuk setiap pertemuan berdasarkan id_member dari tabel BaptistAttendance
        $attendance = BaptistAttendance::where('id_member', $member->id)
                                    ->whereIn('id_baptist_class_detail', $details->pluck('id'))
                                    ->pluck('status', 'id_baptist_class_detail');

        // Mengirim tanggal saat ini ke view
        $today = now()->toDateString();

        return view('memberbaptist.class', compact('class', 'details', 'attendance', 'today'));
    }

}