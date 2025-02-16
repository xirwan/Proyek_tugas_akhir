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

            $query = SundaySchoolPresence::with('member', 'member.sundaySchoolClasses')
            ->leftJoin('sunday_school_members', 'sunday_school_presences.member_id', '=', 'sunday_school_members.member_id')
            ->leftJoin('sunday_school_classes', 'sunday_school_members.sunday_school_class_id', '=', 'sunday_school_classes.id')
            ->orderBy('sunday_school_classes.name', 'asc') // Urutkan berdasarkan nama kelas
            ->select('sunday_school_presences.*'); // Pilih semua kolom dari tabel utama        

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
        $startDate = $request->input('start_date'); // Tanggal mulai
        $endDate = $request->input('end_date'); // Tanggal akhir

        // Ambil absensi berdasarkan filter kelas dan minggu
        $presences = SundaySchoolPresence::with('member', 'member.sundaySchoolClasses')
            ->leftJoin('sunday_school_members', 'sunday_school_presences.member_id', '=', 'sunday_school_members.member_id')
            ->leftJoin('sunday_school_classes', 'sunday_school_members.sunday_school_class_id', '=', 'sunday_school_classes.id')
            ->leftJoin('members', 'sunday_school_members.member_id', '=', 'members.id')
            ->orderBy('sunday_school_classes.name', 'asc') // Urutkan berdasarkan nama kelas
            ->orderBy('members.firstname', 'asc') // Urutkan berdasarkan nama kelas
            ->select('sunday_school_presences.*')
            ->when($selectedClassId !== 'all', function ($query) use ($selectedClassId) {
                return $query->whereHas('member.sundaySchoolClasses', function ($q) use ($selectedClassId) {
                    $q->where('sunday_school_classes.id', $selectedClassId);
                });
            })
            // Filter berdasarkan selectedWeek jika start_date dan end_date tidak ada
            ->when($selectedWeek !== 'all' && !$startDate && !$endDate, function ($query) use ($selectedWeek) {
                return $query->whereDate('week_of', $selectedWeek);
            })
            // Filter berdasarkan rentang tanggal jika start_date dan end_date ada
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('week_of', [$startDate, $endDate]);
            })
            // Jika tidak ada filter minggu atau tanggal, maka ambil semua data
            ->get();

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

        // Ambil presensi yang memiliki check_in yang tidak null (hanya yang hadir)
        $presencesWithCheckIn = $presences->filter(function ($presence) {
            return $presence->check_in !== null;
        });

        // Kelompokkan presensi berdasarkan member_id dan hitung jumlah absensi per anak
        $attendanceCountPerChild = $presencesWithCheckIn->groupBy('member_id')->map(function ($group) {
            return $group->count(); // Menghitung jumlah presensi per anak
        });

        // Urutkan attendanceCountPerChild berdasarkan urutan member_id yang ada pada $presences
        $attendanceCountPerChild = $attendanceCountPerChild->sortKeysUsing(function ($keyA, $keyB) use ($presences) {
            $memberA = $presences->firstWhere('member_id', $keyA)->member;
            $memberB = $presences->firstWhere('member_id', $keyB)->member;
            
            return strcmp($memberA->firstname, $memberB->firstname); // Bandingkan berdasarkan firstname
        });

        // Generate PDF
        $pdf = Pdf::loadView('attendance.attendance-pdf', [
            'presences' => $presences,
            'class' => $class,
            'weekOf' => $startDate && $endDate ? "{$startDate} hingga {$endDate}" : ($selectedWeek === 'all' ? 'Semua Minggu' : $selectedWeek),
            'mentor' => $mentor ? $mentor->member : null,
            'attendanceCountPerChild' => $attendanceCountPerChild, // Kirim data jumlah absensi per anak
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