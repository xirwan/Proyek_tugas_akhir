<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $baptistclass = BaptistClass::findOrFail($id);
        $details = BaptistClassDetail::where('id_baptist_class', $id)->paginate(10);
        return view('baptistclassdetail.index', compact('baptistclass', 'details'));
    }

    /**
     * Tampilkan form untuk membuat pertemuan kelas otomatis.
     */
    public function create($encryptedId)
    {   
        $id = decrypt($encryptedId);
        $baptistclass = BaptistClass::findOrFail($id);
        return view('baptistclassdetail.add', compact('baptistclass'));
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
            'number_of_sessions' => 'required|integer|min:1',
        ]);

        $baptistclass = BaptistClass::findOrFail($id);
        $startDate = Carbon::parse($request->start_date);
        $numberOfSessions = $request->number_of_sessions;
        // Pemetaan nama hari dari bahasa Inggris ke bahasa Indonesia
        $daysMap = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];

        // Dapatkan nama hari dalam bahasa Inggris dari Carbon
        $dayOfWeekInEnglish = $startDate->format('l');

        // Konversi nama hari ke bahasa Indonesia
        $dayOfWeekInIndonesian = $daysMap[$dayOfWeekInEnglish];

        // Pastikan tanggal awal sesuai dengan hari yang ditentukan di baptist_class
        $dayOfWeek = $baptistclass->day; // Nama hari dalam bahasa Indonesia
        if ($dayOfWeekInIndonesian !== $dayOfWeek) {
            return redirect()->back()->withErrors(['start_date' => 'Tanggal awal harus sesuai dengan hari ' . $dayOfWeek]);
        }

        // Buat entri untuk setiap pertemuan berdasarkan jumlah sesi
        for ($i = 0; $i < $numberOfSessions; $i++) {
            $date = $startDate->copy()->addWeeks($i);

            BaptistClassDetail::create([
                'id_baptist_class' => $id,
                'date' => $date,
                'description' => null,
                'status' => 'Active',
                'is_rescheduled' => false,
            ]);
        }

        return redirect()->route('baptist-classes.index')->with('success', 'Detail pertemuan berhasil dibuat.');
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
        // Dekripsi ID pertemuan kelas
        $classDetailId = decrypt($encryptedClassDetailId);

        // Ambil detail pertemuan dengan data peserta
        $classDetail = BaptistClassDetail::with('baptistClass.members.member')->findOrFail($classDetailId);

        return view('baptistclassdetail.attendance', compact('classDetail'));
    }

    public function markAttendance(Request $request, $encryptedClassDetailId)
    {
        // Dekripsi ID pertemuan kelas
        $classDetailId = decrypt($encryptedClassDetailId);

        // Validasi input
        $request->validate([
            'attendance' => 'required|array',
            'attendance.*' => 'in:Hadir,Tidak Hadir',
        ]);

        // Cari detail kelas berdasarkan ID yang didekripsi
        $classDetail = BaptistClassDetail::findOrFail($classDetailId);

        // Update atau buat data absensi untuk setiap peserta
        foreach ($request->attendance as $memberId => $status) {
            BaptistAttendance::updateOrCreate(
                [
                    'id_member' => $memberId,
                    'id_baptist_class_detail' => $classDetail->id,
                ],
                [
                    'status' => $status
                ]
            );
        }

        // Redirect dengan ID yang terenkripsi kembali
        return redirect()->route('baptist-class-detail.index', encrypt($classDetail->id_baptist_class))->with('success', 'Absensi berhasil disimpan.');
    }



}
