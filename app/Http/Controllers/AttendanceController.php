<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\SundaySchoolPresence;
use App\Models\SundaySchoolClass;
use App\Models\Report;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function listChildren()
    {
        // Ambil semua anak yang memiliki orang tua dan paginate hasilnya
        $children = Member::whereHas('parents')->paginate(10);

        return view('attendance.children-list', compact('children'));
    }

    public function generateQrForChild($id)
    {
        $child = Member::findOrFail($id);

        // Tentukan nama dan path file QR code
        $fileName = 'qr_' . $child->id . '.png';
        $filePath = storage_path('app/public/qr-codes/' . $fileName);

        // Pastikan folder 'qr-codes' ada
        if (!file_exists(storage_path('app/public/qr-codes'))) {
            mkdir(storage_path('app/public/qr-codes'), 0777, true);
        }

        // Cek apakah QR code sudah ada
        if (!file_exists($filePath)) {
            // Generate path relatif untuk QR code
            $relativePath = "/qr-code/checkin/{$child->id}";

            // Generate dan simpan QR code sebagai gambar PNG
            QrCode::format('png')->size(300)->generate($relativePath, $filePath);

            // Simpan nama file di database (hanya menyimpan path relatif)
            $child->update(['qr_code' => 'qr-codes/' . $fileName]);
        }

        return redirect()->route('qr-code.children.list')
            ->with('success', 'QR Code berhasil di-generate!');
    }

    public function generateQrForAllChildrenWithoutQr()
    {
        // Ambil semua anak yang belum memiliki QR code
        $childrenWithoutQr = Member::whereHas('parents')
            ->whereNull('qr_code')
            ->get();

        // Pastikan folder 'qr-codes' ada
        if (!file_exists(storage_path('app/public/qr-codes'))) {
            mkdir(storage_path('app/public/qr-codes'), 0777, true);
        }

        // Generate QR code untuk setiap anak
        foreach ($childrenWithoutQr as $child) {
            // Tentukan nama dan path file QR code
            $fileName = 'qr_' . $child->id . '.png';
            $filePath = storage_path('app/public/qr-codes/' . $fileName);

            // Generate path relatif untuk QR code
            $relativePath = "/qr-code/checkin/{$child->id}";

            // Generate dan simpan QR code sebagai gambar PNG
            QrCode::format('png')->size(300)->generate($relativePath, $filePath);

            // Simpan nama file di database (hanya menyimpan path relatif)
            $child->update(['qr_code' => 'qr-codes/' . $fileName]);
        }

        return redirect()->route('qr-code.children.list')
            ->with('success', 'QR Code berhasil di-generate untuk semua anak!');
    }


    public function classList()
    {
        // Atur lokal untuk menghasilkan nama hari dalam bahasa Indonesia
        Carbon::setLocale('id');

        // Ambil semua kelas sekolah minggu
        $classes = SundaySchoolClass::with('schedules')->paginate(10);
        $currentDay = strtolower(Carbon::now()->isoFormat('dddd')); // Ambil hari ini
        $currentTime = Carbon::now()->toTimeString(); // Ambil waktu saat ini

        // Cek apakah jadwal aktif untuk setiap kelas
        foreach ($classes as $class) {
            foreach ($class->schedules as $schedule) {
                if (strtolower($schedule->day) === $currentDay) { // Ubah ke huruf kecil sebelum dibandingkan
                    if ($currentTime >= $schedule->start && $currentTime <= $schedule->end) {
                        $class->isActiveSchedule = true;
                        break; // Jika jadwal aktif, tidak perlu cek lainnya
                    }
                }
            }
        }        
        return view('attendance.class-list', compact('classes'));
    }

    public function showCheckinQr($class_id)
    {
        $class = SundaySchoolClass::findOrFail($class_id);

        // Ambil semua murid yang terdaftar di kelas ini
        $students = Member::whereHas('sundaySchoolClasses', function ($query) use ($class_id) {
            $query->where('sunday_school_classes.id', $class_id);
        })->get();

        // Tentukan minggu aktif (mulai dari hari Minggu)
        $weekOf = Carbon::now()->toDateString();

        // Ambil ID murid yang sudah absen dengan QR Code (check_in tidak null)
        $absentStudents = SundaySchoolPresence::where('week_of', $weekOf)
            ->whereNotNull('check_in') // Hanya murid yang check_in tidak null
            ->whereIn('member_id', $students->pluck('id')->toArray()) // Pastikan hanya murid di kelas ini
            ->with('member') // Pastikan relasi member di-load
            ->get()
            ->map(function ($presence) {
                return (object) [
                    'firstname' => $presence->member->firstname,
                    'lastname' => $presence->member->lastname,
                    'check_in' => $presence->check_in ? Carbon::parse($presence->check_in) : null,
                ];
            });

        // Pastikan $absentStudents tidak null
        $absentStudents = $absentStudents ?? collect([]);

        // Pastikan $students tidak null
        $students = $students ?? collect([]);

        return view('attendance.checkin-qr', compact('class', 'students', 'absentStudents'));
    }



    public function classListAdmin()
    {
        // Atur lokal untuk menghasilkan nama bulan dalam bahasa Indonesia
        Carbon::setLocale('id');

        // Ambil admin yang login dan cari member_id-nya
        $member = Member::where('user_id', Auth::id())->first();

        if (!$member) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke kelas ini.');
        }

        // Ambil nama bulan dan tahun saat ini
        $currentMonth = Carbon::now()->translatedFormat('F'); // Contoh: "Desember"
        $currentYear = Carbon::now()->year;

        // Ambil kelas yang sesuai dengan member berdasarkan bulan (nama dalam bahasa Indonesia) dan tahun
        $classes = SundaySchoolClass::whereHas('scheduleSundaySchoolClasses', function ($query) use ($member, $currentMonth, $currentYear) {
            $query->whereHas('memberSchedules', function ($subQuery) use ($member, $currentMonth, $currentYear) {
                $subQuery->where('member_id', $member->id)
                        ->whereHas('monthlySchedule', function ($monthlyScheduleQuery) use ($currentMonth, $currentYear) {
                            $monthlyScheduleQuery->where('month', $currentMonth)
                                                ->where('year', $currentYear);
                        });
            });
        })
        ->with('schedules') // Pastikan jadwal ikut di-load
        ->paginate(10);

        // Tandai kelas sebagai aktif berdasarkan jadwal, jika diperlukan
        foreach ($classes as $class) {
            foreach ($class->schedules as $schedule) {
                $class->isActiveSchedule = false; // Default: Tidak aktif
                if (strtolower($schedule->day) === strtolower(Carbon::now()->isoFormat('dddd'))) {
                    $class->isActiveSchedule = true;
                    break;
                }
            }
        }

        return view('attendance.admin-class-list', compact('classes'));
    }

    public function checkinByClass(Request $request, $class_id)
    {
        // Ambil nilai `member_id` dari QR code
        $url = $request->member_id;

        // Ambil path dari URL (abaikan domain)
        $path = parse_url($url, PHP_URL_PATH);

        // Ekstrak angka `member_id` dari path, contoh: "/qr-code/checkin/5" menjadi "5"
        if (preg_match('/\/checkin\/(\d+)$/', $path, $matches)) {
            $memberId = $matches[1];
        } else {
            return redirect()->route('attendance.showCheckinQr', $class_id)
                ->withErrors('QR Code tidak valid.');
        }

        // Validasi member_id
        $request->merge(['member_id' => $memberId]);
        $request->validate([
            'member_id' => 'required|exists:members,id',
        ]);

        // Cek apakah murid terdaftar di kelas yang dipilih
        $isMemberOfClass = DB::table('sunday_school_members')
            ->where('member_id', $memberId)
            ->where('sunday_school_class_id', $class_id)
            ->exists();

        if (!$isMemberOfClass) {
            return redirect()->route('attendance.showCheckinQr', $class_id)
                ->withErrors('Murid tidak terdaftar di kelas ini.');
        }

        // Tentukan minggu aktif (mulai hari Minggu ini)
        $weekOf = Carbon::now()->toDateString();

        // Cek apakah murid sudah absen minggu ini
        $attendance = SundaySchoolPresence::where('member_id', $memberId)
            ->whereDate('week_of', $weekOf)
            ->first();

        if ($attendance) {
            // Jika `check_in` masih null, perbarui dengan waktu sekarang
            if (!$attendance->check_in) {
                $attendance->update([
                    'check_in' => now(),
                ]);
                return back()->with('success', 'QR Code berhasil dipindai, absensi diperbarui!');
            }

            return back()->with('success', 'Murid ini sudah absen minggu ini.');
        }

        // Jika belum ada data absensi, buat data baru
        SundaySchoolPresence::create([
            'member_id' => $memberId,
            'check_in' => now(),
            'week_of' => $weekOf,
        ]);

        return back()->with('success', 'Absensi berhasil dicatat untuk minggu ini!');
    }

    public function attendanceListByClass($class_id)
    {
        // Tentukan minggu aktif (mulai hari Minggu ini) untuk menampilkan absensi mingguan
        // $weekOf = Carbon::now()->startOfWeek(Carbon::SUNDAY)->toDateString();
        // Untuk testing, gunakan tanggal hari ini sebagai minggu aktif
        $weekOf = Carbon::now()->toDateString();
        // $weekOf = now()->startOfWeek(Carbon::SUNDAY)->toDateString();

        // Dapatkan murid yang terdaftar di kelas ini dengan menyertakan alias untuk `id`
        $students = Member::whereHas('sundaySchoolClasses', function ($query) use ($class_id) {
            $query->where('sunday_school_classes.id', $class_id); // Tambahkan alias tabel di sini
        })->get();

        // Ambil ID murid yang sudah absen pada minggu ini
        $presentStudentIds = SundaySchoolPresence::whereDate('week_of', $weekOf)
        ->whereIn('member_id', $students->pluck('id')->toArray()) // Pastikan hanya murid di kelas ini
        ->pluck('member_id')
        ->toArray();

        // Dapatkan data kelas untuk tampilan
        $class = SundaySchoolClass::findOrFail($class_id);

        return view('attendance.class-attendance', [
            'students' => $students,
            'presentStudentIds' => $presentStudentIds,
            'weekOf' => $weekOf,
            'class' => $class,
        ]);
    }

    public function manualCheckin(Request $request, $class_id)
    {
        // Validasi dan ambil data dari request
        $manualCheckins = $request->input('manual_checkins', []);

        $request->validate([
            'manual_checkins' => 'array',                   // Pastikan input berupa array
            'manual_checkins.*' => 'exists:members,id',     // Pastikan setiap ID anggota ada di tabel `members`
        ]);

        // Tentukan minggu aktif untuk absensi (mulai hari Minggu)
        $weekOf = Carbon::now()->toDateString();

        // Ambil ID admin yang melakukan checklist manual
        $adminId = Auth::user()->id;

        // Ambil semua siswa di kelas
        $students = Member::whereHas('sundaySchoolClasses', function ($query) use ($class_id) {
            $query->where('sunday_school_classes.id', $class_id); // Filter siswa berdasarkan kelas
        })->get();

        // Ambil data absensi minggu ini untuk setiap siswa
        foreach ($students as $student) {
            $attendance = SundaySchoolPresence::where('member_id', $student->id)
                                            ->whereDate('week_of', $weekOf)
                                            ->first();

            // Cek apakah siswa sudah absen
            if ($attendance) {
                // Jika siswa sudah absen, hanya update jika dicentang pada manual check-in
                if (in_array($student->id, $manualCheckins)) {
                    // Jika checkbox dicentang, update check_in ke waktu sekarang
                    $attendance->update([
                        'check_in' => now(),
                        'admin_check_in' => $adminId, // Set admin yang melakukan check-in
                    ]);
                }
            } else {
                // Jika siswa belum ada absensinya, buat data baru dengan check_in null jika tidak dicentang
                SundaySchoolPresence::create([
                    'member_id' => $student->id,
                    'check_in' => in_array($student->id, $manualCheckins) ? now() : null, // Set check_in berdasarkan apakah dicentang atau tidak
                    'week_of' => $weekOf,
                    'admin_check_in' => in_array($student->id, $manualCheckins) ? $adminId : null, // Set admin jika dicentang
                ]);
            }
        }

        return redirect()->route('attendance.classAttendance', $class_id)->with('success', 'Checklist manual berhasil disimpan untuk minggu ini!');
    }

    public function parentViewAttendance(Request $request)
    {
        // Ambil ID user yang sedang login
        $parent = Member::where('user_id', Auth::id())->first();

        // Pastikan orang tua valid
        if (!$parent) {
            return back()->withErrors('Data orang tua tidak ditemukan.');
        }

        // Ambil daftar anak dari relasi children
        $children = $parent->children;

        // Dapatkan ID anak yang dipilih (jika ada)
        $selectedChildId = $request->input('child_id');

        // Ambil data anak yang dipilih
        $selectedChild = $selectedChildId ? $children->where('id', $selectedChildId)->first() : null;

        // Ambil absensi anak yang dipilih
        $reports = [];
        $attendanceRecords = [];
        if ($selectedChild) {
            $attendanceRecords = SundaySchoolPresence::with('member.sundaySchoolClasses')
                ->where('member_id', $selectedChild->id)
                ->orderBy('week_of', 'desc')
                ->get();

                 // Ambil laporan berdasarkan kelas dan minggu
            $classId = $selectedChild->sundaySchoolClasses->first()->id ?? null;
            if ($classId) {
                $reports = Report::where('sunday_school_class_id', $classId)
                    ->whereIn('week_of', $attendanceRecords->pluck('week_of'))
                    ->get();
            }
        }

        return view('childrens.attendance-view', [
            'children' => $children,
            'selectedChild' => $selectedChild,
            'attendanceRecords' => $attendanceRecords,
            'reports' => $reports,
        ]);
    }

}