<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Certification;
use App\Models\Member;
use App\Models\Position;


class CertificationController extends Controller
{
    //
    public function index()
    {
        // Ambil semua data sertifikasi dengan pagination
        $certifications = Certification::with('member')->paginate(10);

        // Kirim data ke view
        return view('certifications.index', compact('certifications'));
    }


    public function show($encryptedId)
    {
        // Dekripsi ID dari URL
        $id = decrypt($encryptedId);

        // Lanjutkan dengan query atau operasi lainnya
        $certification = Certification::findOrFail($id);

        return view('certifications.show', compact('certification'));
    }

    public function verify(Request $request, $encryptedId)
    {
        // Dekripsi ID
        $id = decrypt($encryptedId);

        // Ambil data sertifikasi
        $certification = Certification::findOrFail($id);

        // Update status sertifikasi
        // Konversi nilai checkbox menjadi boolean
        $certification->seminar_certified = $request->has('seminar_certified') ? 1 : 0;
        $certification->baptism_certified = $request->has('baptism_certified') ? 1 : 0;
        $certification->rejection_reason = null; // Bersihkan alasan penolakan jika diverifikasi
        $certification->save();

          // Periksa apakah kedua sertifikat sudah terverifikasi
        if ($certification->seminar_certified && $certification->baptism_certified) {
            // Ubah position_id anggota menjadi ID posisi untuk "Jemaat Tetap"
            $member = $certification->member; // Ambil relasi member dari sertifikasi

            // Cari ID posisi "Jemaat Tetap" di tabel posisi
            $positionId = Position::where('name', 'Jemaat Tetap')->value('id');

            // Perbarui position_id anggota
            if ($positionId) {
                $member->position_id = $positionId;
                $member->save();
            }
        }

        return redirect()->route('certifications.index')->with('success', 'Sertifikasi berhasil diverifikasi.');
    }

    public function reject(Request $request, $encryptedId)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        // Dekripsi ID
        $id = decrypt($encryptedId);

        // Ambil data sertifikasi
        $certification = Certification::findOrFail($id);

        // Update alasan penolakan
        $certification->seminar_certified = false;
        $certification->baptism_certified = false;
        $certification->rejection_reason = $request->input('rejection_reason');
        $certification->save();

        // Perbarui position_id anggota menjadi ID posisi untuk "Jemaat"
        $member = $certification->member; // Ambil relasi member dari sertifikasi

         // Ambil user yang terkait dengan member
        $user = $member->user;

        // Cek role yang dimiliki oleh user
        if ($user->hasRole('JemaatRemaja')) {
            // Jika role adalah "JemaatRemaja", set position_id menjadi "Jemaat Remaja"
            $positionId = Position::where('name', 'Jemaat Remaja')->value('id');
        } else {
            // Jika role adalah "Jemaat", set position_id menjadi "Jemaat"
            $positionId = Position::where('name', 'Jemaat')->value('id');
        }

        // Perbarui position_id anggota
        if ($positionId) {
            $member->position_id = $positionId;
            $member->save();
        }

        return redirect()->route('certifications.index')->with('error', 'Sertifikasi ditolak dengan alasan: ' . $certification->rejection_reason);
    }


    public function showUploadForm()
    {
        // Ambil data anggota yang sedang login
        $user = Auth::user();
        $member = Member::where('user_id', $user->id)->first();

        // Ambil data sertifikasi jika sudah ada
        $certification = $member->certification;

        // Kirim data ke view
        return view('certifications.upload', compact('certification'));
    }


    public function uploadCertificate(Request $request)
    {
        $user = Auth::user();
        $member = Member::where('user_id', $user->id)->first();
        $certification = $member->certification;

        // Cegah unggah jika sedang dalam proses verifikasi
        if ($certification && !$certification->rejection_reason && (!$certification->seminar_certified || !$certification->baptism_certified)) {
            return redirect()->back()->with('error', 'Anda tidak dapat mengunggah sertifikat saat dalam proses verifikasi.');
        }
        // Validasi file yang diunggah
        $request->validate([
            'seminar_file' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'baptism_file' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        // Ambil data anggota terkait dari user yang sedang login
        // $member = auth()->user->member;
        $user = Auth::user();
        $member = Member::where('user_id', $user->id)->first();

        // Ambil atau buat data sertifikasi
        $certification = $member->certification ?? new Certification();
        $certification->member_id = $member->id;

        // Simpan file seminar jika diunggah
        if ($request->hasFile('seminar_file')) {
            $seminarFilePath = $request->file('seminar_file')->store('certifications/seminar', 'public');
            $certification->seminar_file = $seminarFilePath;
        }

        // Simpan file baptis jika diunggah
        if ($request->hasFile('baptism_file')) {
            $baptismFilePath = $request->file('baptism_file')->store('certifications/baptism', 'public');
            $certification->baptism_file = $baptismFilePath;
        }

        // Simpan atau update sertifikasi
        $certification->save();

        return redirect()->back()->with('success', 'Sertifikat berhasil diunggah.');
    }


}
