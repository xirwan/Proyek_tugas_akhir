<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Baptist;
use App\Models\BaptistClass;
use App\Models\BaptistClassDetail;
use App\Models\BaptistAttendance;
use Carbon\Carbon;

class BaptistClassDetailController extends Controller
{
    /**
     * Tampilkan daftar semua pertemuan kelas.
     */
    public function index($encryptedId)
    {
        $id = decrypt($encryptedId);
        $baptist = Baptist::findOrFail($id);
        $details = BaptistClassDetail::where('id_baptist', $id)->paginate(10);
        return view('baptistclassdetail.index', compact('baptist', 'details'));
    }
    

    /**
     * Tampilkan form untuk membuat pertemuan kelas otomatis.
     */
    public function create($encryptedId)
    {
        $id = decrypt($encryptedId);
        $baptist = Baptist::findOrFail($id);
        return view('baptistclassdetail.add', compact('baptist'));
    }
    /**
     * Simpan pertemuan kelas otomatis ke database.
     */
    public function store(Request $request, $encryptedId)
    {
        $id = decrypt($encryptedId);

        // Validasi input dari admin
        $request->validate([
            'start_date' => 'required|date',
        ]);

        $baptist = Baptist::findOrFail($id);
        $startDate = Carbon::parse($request->start_date);

        // Pastikan tanggal awal berada sebelum tanggal baptis
        if ($startDate->greaterThanOrEqualTo(Carbon::parse($baptist->date))) {
            return redirect()->back()->withErrors(['start_date' => 'Tanggal pertemuan harus sebelum tanggal baptis.']);
        }

        // Simpan detail pertemuan
        BaptistClassDetail::create([
            'id_baptist' => $id,
            'date' => $startDate,
            'description' => 'Pertemuan persiapan untuk baptis',
            'status' => 'Active',
            'is_rescheduled' => false,
        ]);

        return redirect()->route('baptist-class-detail.index', encrypt($id))->with('success', 'Pertemuan berhasil dibuat.');
    }

    /**
     * Tampilkan form untuk membatalkan dan menjadwal ulang pertemuan kelas.
     */
    public function cancelAndRescheduleForm($classDetailId)
    {
        $classDetail = BaptistClassDetail::findOrFail($classDetailId);
        return view('baptist_class_detail.cancel_reschedule', compact('classDetail'));
    }

    /**
     * Batalkan dan jadwalkan ulang pertemuan kelas.
     */
    public function cancelAndReschedule(Request $request, $classDetailId)
    {
        // Validasi input dari admin
        $request->validate([
            'reschedule_date' => 'required|date',
        ]);

        $classDetail = BaptistClassDetail::findOrFail($classDetailId);

        // Tandai pertemuan asli sebagai "Inactive" dan atur sebagai dijadwal ulang
        $classDetail->update([
            'status' => 'Inactive',
            'is_rescheduled' => true,
            'reschedule_date' => $request->reschedule_date,
        ]);

        // Buat entri baru untuk pertemuan yang dijadwal ulang
        BaptistClassDetail::create([
            'id_baptist_class' => $classDetail->id_baptist_class,
            'date' => $request->reschedule_date,
            'description' => 'Pertemuan pengganti untuk tanggal ' . $classDetail->date,
            'status' => 'Active',
            'is_rescheduled' => false,
            'original_class_detail_id' => $classDetail->id,
        ]);

        return redirect()->route('baptist_class_detail.index')->with('success', 'Pertemuan berhasil dibatalkan dan dijadwal ulang.');
    }

    public function attendanceForm($encryptedClassDetailId)
    {
        $classDetailId = decrypt($encryptedClassDetailId);

        // Ambil detail kelas dengan data peserta dari relasi memberBaptists
        $classDetail = BaptistClassDetail::with(['memberBaptists.member', 'attendances.member'])->findOrFail($classDetailId);

        return view('baptistclassdetail.attendance', compact('classDetail'));
    }

    public function markAttendance(Request $request, $encryptedClassDetailId)
    {
        $classDetailId = decrypt($encryptedClassDetailId);

        // Validasi input
        $request->validate([
            'attendance' => 'required|array',
        ]);

        $classDetail = BaptistClassDetail::with('attendances')->findOrFail($classDetailId);

        foreach ($request->attendance as $memberId => $status) {
            // Periksa apakah peserta sudah diabsen
            $existingAttendance = $classDetail->attendances->firstWhere('id_member', $memberId);
            if (!$existingAttendance) {
                // Hanya buat absensi untuk peserta yang belum diabsen
                BaptistAttendance::create([
                    'id_member' => $memberId,
                    'id_baptist_class_detail' => $classDetail->id,
                    'status' => $status,
                ]);
            }
        }

        return redirect()->route('baptist-class-detail.attendanceForm', encrypt($classDetail->id))
                        ->with('success', 'Absensi berhasil disimpan.');
    }

}
