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
        $selectedClassId = $request->input('class_id', null);
        $selectedWeek = $request->input('week_of', null);
        $useDateRange = $request->input('use_date_range', false);
        $startDate = $request->input('start_date', null);
        $endDate = $request->input('end_date', null);

        $classes = SundaySchoolClass::all();
        $weeks = SundaySchoolPresence::select('week_of')
            ->distinct()
            ->orderBy('week_of', 'desc')
            ->get()
            ->pluck('week_of', 'week_of')
            ->prepend('Semua Minggu', 'all');

        $query = SundaySchoolPresence::with('member', 'member.sundaySchoolClasses');

        if ($useDateRange && $startDate && $endDate) {
            $query->whereBetween('week_of', [$startDate, $endDate]);
        } else {
            if ($selectedWeek !== 'all') {
                $query->whereDate('week_of', $selectedWeek);
            }
        }

        if ($selectedClassId !== 'all') {
            $query->whereHas('member.sundaySchoolClasses', function ($q) use ($selectedClassId) {
                $q->where('sunday_school_classes.id', $selectedClassId);
            });
        }

        $presences = $query->paginate(10)->appends($request->query());

        return view('attendance.class-attendance-history', compact('classes', 'presences', 'selectedClassId', 'selectedWeek', 'weeks', 'startDate', 'endDate', 'useDateRange'));
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