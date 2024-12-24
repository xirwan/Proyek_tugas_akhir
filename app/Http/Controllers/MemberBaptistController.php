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
        // Mendapatkan data jadwal pembaptisan dengan detail pertemuan
        $baptists = Baptist::with('details')->get();

        // Ambil daftar detail pertemuan yang sudah didaftarkan oleh pengguna yang sedang login
        $registeredDetails = Auth::user()->member 
            ? Auth::user()->member->memberBaptists->pluck('id_baptist_class_detail')->toArray() 
            : [];

        // Cek apakah user sudah mendaftar
        $isAlreadyRegistered = !empty($registeredDetails);

        return view('memberbaptist.index', compact('baptists', 'registeredDetails', 'isAlreadyRegistered'));
    }


    public function register(Request $request)
    {
        // Validasi data input
        $request->validate([
            'baptist_id' => 'required',
            'baptist_detail_id' => 'required',
        ]);

        $baptistDetailId = $request->baptist_detail_id;

        // Ambil id_member dari pengguna yang sedang login
        $idMember = Auth::user()->member->id;

        // Cek apakah user sudah mendaftar di detail pertemuan yang sama
        $existingRegistration = MemberBaptist::where('id_member', $idMember)
                                            ->where('id_baptist_class_detail', $baptistDetailId)
                                            ->first();

        if ($existingRegistration) {
            return redirect()->back()->with('error', 'Anda sudah terdaftar di detail pertemuan ini.');
        }

        // Simpan data pendaftaran
        MemberBaptist::create([
            'id_member' => $idMember,
            'id_baptist_class_detail' => $baptistDetailId,
        ]);

        return redirect()->route('portal')->with('success', 'Pendaftaran berhasil.');
    }

    public function showDetails()
    {
        $user = Auth::user();
        $member = $user->member;

        // Dapatkan detail pertemuan yang diikuti member ini
        $memberBaptist = MemberBaptist::with(['classDetail.baptist'])->where('id_member', $member->id)->first();

        if (!$memberBaptist) {
            return redirect()->back()->with('error', 'Anda belum terdaftar di jadwal pembaptisan.');
        }

        $classDetail = $memberBaptist->classDetail;
        $baptist = $classDetail->baptist;

        // Ambil detail pertemuan dari jadwal pembaptisan
        $details = $baptist->details()->paginate(10);

        // Mengambil kehadiran untuk setiap pertemuan berdasarkan id_member dari tabel BaptistAttendance
        $attendance = BaptistAttendance::where('id_member', $member->id)
                                        ->whereIn('id_baptist_class_detail', $details->pluck('id'))
                                        ->pluck('status', 'id_baptist_class_detail');

        // Mengirim tanggal saat ini ke view
        $today = now()->toDateString();

        return view('memberbaptist.class', compact('classDetail', 'details', 'attendance', 'today'));
    }


}