<?php

namespace App\Http\Controllers;

use App\Models\SundaySchoolPresence;
use App\Models\SundaySchoolClass;
use App\Models\MemberScheduleMonthly;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminAttendanceController extends Controller
{
    // Fungsi untuk menampilkan riwayat absensi dengan filter dan pagination
    public function attendanceHistory(Request $request)
    {
        $selectedClassId = $request->input('class_id', null); // Default ke null
        $selectedWeek = $request->input('week_of', null); // Default ke null

        // Ambil semua kelas
        $classes = SundaySchoolClass::all();

        // Ambil tanggal week_of unik dari tabel absensi
        $weeks = SundaySchoolPresence::select('week_of')
            ->distinct()
            ->orderBy('week_of', 'desc')
            ->get()
            ->pluck('week_of', 'week_of') // Format: ['2024-11-12' => '2024-11-12']
            ->prepend('Semua Minggu', 'all'); // Tambahkan opsi "Semua Minggu"

        // Jika admin belum memilih filter, tampilkan halaman tanpa data absensi
        if (is_null($selectedClassId) || is_null($selectedWeek)) {
            return view('attendance.class-attendance-history', compact('classes', 'weeks', 'selectedClassId', 'selectedWeek'))
                ->with('presences', collect()); // Kirim presences kosong
        }

        // Query absensi dengan pagination
        $query = SundaySchoolPresence::with('member', 'member.sundaySchoolClasses');

        if ($selectedClassId !== 'all') {
            $query->whereHas('member.sundaySchoolClasses', function ($q) use ($selectedClassId) {
                $q->where('sunday_school_classes.id', $selectedClassId);
            });
        }

        if ($selectedWeek !== 'all') {
            $query->whereDate('week_of', $selectedWeek);
        }

        $presences = $query->paginate(10)->appends(request()->query()); // Tambahkan query string ke pagination

        return view('attendance.class-attendance-history', compact('classes', 'presences', 'selectedClassId', 'selectedWeek', 'weeks'));
    }


    // Fungsi untuk export data absensi ke PDF
    public function exportToPdf(Request $request)
    {
        $selectedClassId = $request->input('class_id', 'all'); // Default ke 'all'
        $selectedWeek = $request->input('week_of', 'all'); // Default ke 'all'

        // Ambil absensi berdasarkan filter kelas dan minggu
        $presences = SundaySchoolPresence::with('member', 'member.sundaySchoolClasses')
            ->when($selectedClassId !== 'all', function ($query) use ($selectedClassId) {
                return $query->whereHas('member.sundaySchoolClasses', function ($q) use ($selectedClassId) {
                    $q->where('sunday_school_classes.id', $selectedClassId);
                });
            })
            ->when($selectedWeek !== 'all', function ($query) use ($selectedWeek) {
                return $query->whereDate('week_of', $selectedWeek);
            })
            ->get(); // Semua data untuk PDF

        // Jika tidak ada data presences, kembali dengan pesan error
        if ($presences->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data absensi untuk diekspor.');
        }

        // Ambil informasi kelas jika ada kelas yang dipilih
        $class = $selectedClassId !== 'all' ? SundaySchoolClass::find($selectedClassId) : null;

        // Cari pembina berdasarkan jadwal yang sesuai
        $scheduleQuery = MemberScheduleMonthly::with('member')
            ->where('schedule_date', $selectedWeek);
        if ($selectedClassId !== 'all') {
            $scheduleQuery->whereHas('scheduleSundaySchoolClass', function ($query) use ($selectedClassId) {
                $query->where('id', $selectedClassId);
            });
        }
        $mentor = $scheduleQuery->first();

        // Generate PDF
        $pdf = Pdf::loadView('attendance.attendance-pdf', [
            'presences' => $presences,
            'class' => $class,
            'weekOf' => $selectedWeek === 'all' ? 'Semua Minggu' : $selectedWeek,
            'mentor' => $mentor ? $mentor->member : null,
        ]);

        // Nama file PDF berdasarkan pilihan
        $fileName = 'attendance_report_' .
            ($class ? $class->name : 'all_classes') .
            '_' .
            ($selectedWeek === 'all' ? 'all_weeks' : $selectedWeek) .
            '.pdf';

        // Return file PDF untuk diunduh
        return $pdf->stream($fileName);
    }

}