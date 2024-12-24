<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seminar;
use App\Models\SeminarRegistration;
use App\Models\Baptist;
use App\Models\BaptistClassDetail;
use App\Models\BaptistAttendance;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class GenerateCertification extends Controller
{
    //
    public function indexSeminar()
    {
        $seminars = Seminar::where('status', 'completed')->paginate(10);
        return view('generate.indexseminar', compact ('seminars'));
    }

    public function indexPembaptisan()
    {
        // Ambil data jadwal pembaptisan yang memiliki detail
        $baptists = Baptist::whereHas('details') // Hanya ambil data yang memiliki relasi ke details
                            ->paginate(10);

        // Kirim data ke view
        return view('generate.indexpembaptisan', compact('baptists'));
    }

    public function indexPembaptisanDetail($encryptedId)
    {   
        $id = decrypt($encryptedId);
        $baptist = Baptist::findOrFail($id);
        $details = BaptistClassDetail::where('id_baptist', $id)->paginate(10);
        return view('generate.indexpembaptisandetail', compact('baptist', 'details'));
    }


    public function showMemberSeminar($id)
    {
        $seminar = Seminar::with(['registrations' => function ($query) {
            $query->where('is_attended', true)->with('member');
        }])->findOrFail($id);

        return view('generate.memberlistseminar', compact('seminar'));
    }

    public function showMemberPembaptisan($encryptedClassDetailId)
    {
        $classDetailId = decrypt($encryptedClassDetailId);

        // Ambil detail kelas dengan peserta yang memiliki status 'Hadir'
        $classDetail = BaptistClassDetail::with([
            'memberBaptists.member',
            'attendances' => function ($query) {
                $query->where('status', 'Hadir'); // Filter berdasarkan status 'Hadir'
            }
        ])->findOrFail($classDetailId);

        return view('generate.memberlistpembaptisan', compact('classDetail'));
    }

    public function generateCertificateSeminar($id)
    {
        // Ambil seminar beserta peserta yang sudah hadir
        $seminar = Seminar::with(['registrations' => function ($query) {
            $query->where('is_attended', true)->with('member');
        }])->findOrFail($id);

        if ($seminar->registrations->isEmpty()) {
            return redirect()->back()->with('success', 'Tidak ada peserta yang hadir untuk seminar ini.');
        }

        foreach ($seminar->registrations as $registration) {
            $participantName = $registration->member->firstname . ' ' . $registration->member->lastname;
            $seminarName = $seminar->name;

            // Generate PDF Sertifikat
            $pdf = PDF::loadView('generate.templateseminar', [
                'participantName' => $participantName,
                'seminarName' => $seminarName,
                'eventDate' => $seminar->event_date,
            ]);

            // Simpan Sertifikat ke Disk
            $certificatePath = 'certificates/' . uniqid() . '.pdf';
            Storage::put($certificatePath, $pdf->output());

            // Simpan URL Sertifikat ke Database
            $registration->certificate_url = Storage::url($certificatePath);
            $registration->save();
        }

        return redirect()->back()->with('success', 'Sertifikat berhasil digenerate untuk peserta yang hadir.');
    }

    public function generateCertificatePembaptisan($encryptedClassDetailId)
    {
        $classDetailId = decrypt($encryptedClassDetailId);

        // Ambil detail kelas pembaptisan beserta peserta yang hadir
        $classDetail = BaptistClassDetail::with(['attendances' => function ($query) {
            $query->where('status', 'Hadir')->with('member');
        }])->findOrFail($classDetailId);

        if ($classDetail->attendances->isEmpty()) {
            return redirect()->back()->with('success', 'Tidak ada peserta yang hadir untuk pembaptisan ini.');
        }

        foreach ($classDetail->attendances as $attendance) {
            $participantName = $attendance->member->firstname . ' ' . $attendance->member->lastname;
            $baptistDate = $classDetail->date;

            // Generate PDF Sertifikat
            $pdf = PDF::loadView('generate.templatepembaptisan', [
                'participantName' => $participantName,
                'baptistDate' => $baptistDate,
            ]);

            // Simpan Sertifikat ke Disk
            $certificatePath = 'certificates/baptist/' . uniqid() . '.pdf';
            Storage::put($certificatePath, $pdf->output());

            // Simpan URL Sertifikat ke Database
            $attendance->certificate_url = Storage::url($certificatePath);
            $attendance->save();
        }

        return redirect()->back()->with('success', 'Sertifikat berhasil digenerate untuk peserta yang hadir.');
    }

    public function viewCertificateSeminar($id)
    {
        $registration = SeminarRegistration::findOrFail($id);

        if (!$registration->certificate_url) {
            return redirect()->back()->with('error', 'Sertifikat belum digenerate untuk peserta ini.');
        }

        // Path ke sertifikat
        $certificatePath = str_replace('/storage/', '', $registration->certificate_url);

        // Gunakan response file untuk membuka file PDF di tab baru
        return response()->file(storage_path('app/' . $certificatePath));
    }

    public function viewCertificatePembaptisan($id)
    {
        $attendance = BaptistAttendance::findOrFail($id);

        if (!$attendance->certificate_url) {
            return redirect()->back()->with('error', 'Sertifikat belum digenerate untuk peserta ini.');
        }

        // Path ke sertifikat
        $certificatePath = str_replace('/storage/', '', $attendance->certificate_url);

        // Gunakan response file untuk membuka file PDF di tab baru
        return response()->file(storage_path('app/' . $certificatePath));
    }

    public function seminarCertificates()
    {
        $user = Auth::user();

        // Ambil seminar yang dihadiri oleh pengguna dan sudah memiliki sertifikat
        $seminarRegistrations = SeminarRegistration::where('user_id', $user->id)
            ->whereNotNull('certificate_url') // Hanya yang memiliki sertifikat
            ->with('seminar')
            ->get();

        return view('seminars.certificate', compact('seminarRegistrations'));
    }

    public function baptistCertificates()
    {
        $user = Auth::user();

        // Ambil kehadiran pembaptisan yang memiliki sertifikat
        $baptistAttendances = BaptistAttendance::where('id_member', $user->member->id)
            ->whereNotNull('certificate_url') // Hanya yang memiliki sertifikat
            ->with('classDetail.baptist')
            ->get();

        return view('memberbaptist.certificate', compact('baptistAttendances'));
    }


}