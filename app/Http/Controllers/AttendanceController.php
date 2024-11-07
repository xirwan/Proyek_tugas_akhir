<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\SundaySchoolPresence;
use App\Models\SundaySchoolClass;
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
        $children = Member::whereHas('parents')->paginate(3);

        return view('attendance.children-list', compact('children'));
    }

    // Generate QR code untuk anak tertentu
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
            // Generate URL untuk QR code hanya dengan ID anak
            // $url = route('qr-code.checkin', ['id' => $child->id]);
            $url = route('qr-code.children.generate.qr', ['id' => $child->id]);
            // Generate dan simpan QR code sebagai gambar PNG
            QrCode::format('png')->size(300)->generate($url, $filePath);

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

            // Generate URL untuk QR code hanya dengan ID anak
            // $qrUrl = route('qr-code.checkin', ['id' => $child->id]);
            $qrUrl = route('qr-code.children.generate.qr', ['id' => $child->id]);

            // Generate dan simpan QR code sebagai gambar PNG
            QrCode::format('png')->size(300)->generate($qrUrl, $filePath);

            // Simpan nama file di database (hanya menyimpan path relatif)
            $child->update(['qr_code' => 'qr-codes/' . $fileName]);
        }

        return redirect()->route('qr-code.children.list')
            ->with('success', 'QR Code berhasil di-generate untuk semua anak!');
    }

    public function classList()
    {
        // Ambil semua kelas sekolah minggu
        $classes = SundaySchoolClass::paginate(3);

        return view('attendance.class-list', ['classes' => $classes]);
    }


    // Fungsi check-in otomatis dengan QR code
    // public function checkIn($id)
    // {
    //     // Temukan member berdasarkan ID
    //     $member = Member::findOrFail($id);

    //     // Cek apakah member sudah check-in hari ini
    //     $alreadyCheckedIn = SundaySchoolPresence::where('member_id', $id)
    //         ->whereDate('check_in', now()->toDateString())
    //         ->exists();

    //     if ($alreadyCheckedIn) {
    //         return redirect()->route('attendance.children.list')
    //             ->with('info', 'Anak ini sudah melakukan check-in hari ini.');
    //     }

    //     // Simpan data kehadiran baru
    //     SundaySchoolPresence::create([
    //         'member_id' => $id,
    //         'check_in' => now(),
    //     ]);

    //     return redirect()->route('attendance.children.list')
    //         ->with('success', 'Check-in berhasil!');
    // }

    // public function checkin($id)
    // {

    //     // Untuk testing, abaikan minggu aktif dan gunakan minggu ini sebagai acuan
    //     $weekOf = now()->startOfWeek(Carbon::SUNDAY)->toDateString();

    //     $alreadyCheckedIn = SundaySchoolPresence::where('member_id', $id)
    //         ->whereDate('week_of', $weekOf)
    //         ->exists();

    //     if (!$alreadyCheckedIn) {
    //         SundaySchoolPresence::create([
    //             'member_id' => $id,
    //             'check_in' => now(),
    //             'week_of' => $weekOf,
    //         ]);
    //     }

    //     return redirect()->route('attendance.list')->with('success', 'Absensi berhasil dicatat untuk minggu ini!');
    // }

    public function showCheckinQr($class_id)
    {
        // $class = SundaySchoolClass::findOrFail($class_id);
        // // Ambil semua murid di kelas
        // $students = Member::whereHas('sundaySchoolClasses', function ($query) use ($class_id) {
        //     $query->where('sunday_school_classes.id', $class_id);
        // })->get();

        // // Ambil murid yang sudah absen minggu ini
        // // $weekOf = Carbon::now()->startOfWeek(Carbon::SUNDAY)->toDateString();
        // $weekOf = Carbon::now()->toDateString();
        // $absentStudentIds = SundaySchoolPresence::where('week_of', $weekOf)
        //     ->pluck('member_id')
        //     ->toArray();
        // $absentStudents = Member::whereIn('id', $absentStudentIds)->get();

        // return view('attendance.checkin-qr', compact('class', 'students', 'absentStudents'));
        $class = SundaySchoolClass::findOrFail($class_id);

        // Ambil semua murid yang terdaftar di kelas ini
        $students = Member::whereHas('sundaySchoolClasses', function ($query) use ($class_id) {
            $query->where('sunday_school_classes.id', $class_id);
        })->get();

        // Tentukan minggu aktif (mulai dari hari Minggu)
        // $weekOf = Carbon::now()->startOfWeek(Carbon::SUNDAY)->toDateString();
        $weekOf = Carbon::now()->toDateString();

        // Ambil ID murid yang sudah absen di kelas ini untuk minggu ini
        $absentStudentIds = SundaySchoolPresence::where('week_of', $weekOf)
            ->whereIn('member_id', $students->pluck('id')->toArray()) // Pastikan hanya murid di kelas ini
            ->pluck('member_id')
            ->toArray();

        // Ambil data murid yang sudah absen di kelas ini
        $absentStudents = $students->whereIn('id', $absentStudentIds);
        return view('attendance.checkin-qr', compact('class', 'students', 'absentStudents'));
    }

    public function checkinByClass(Request $request, $class_id)
    {
        // Ambil nilai `member_id` dari QR code
        $url = $request->member_id;

        // Ekstrak angka `member_id` dari path, contoh: "qr-codes/qr_5.png" menjadi "5"
        if (preg_match('/checkin\/(\d+)$/', $url, $matches)) {
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
        // $weekOf = now()->startOfWeek(Carbon::SUNDAY)->toDateString();
        $weekOf = Carbon::now()->toDateString();


        // Cek apakah murid sudah absen minggu ini
        $alreadyCheckedIn = SundaySchoolPresence::where('member_id', $memberId)
            ->whereDate('week_of', $weekOf)
            ->first();

        // if (!$alreadyCheckedIn) {
        //     // Catat absensi untuk minggu ini tanpa class_id
        //     SundaySchoolPresence::create([
        //         'member_id' => $memberId,
        //         'check_in' => now(),
        //         'week_of' => $weekOf,
        //     ]);
        // }

        if ($alreadyCheckedIn !== null) { // Pastikan hanya memicu jika $alreadyCheckedIn tidak null
            return back()->withErrors('Murid ini sudah absen minggu ini.');
        }
    
        // Jika belum absen, catat absensi untuk minggu ini
        SundaySchoolPresence::create([
            'member_id' => $memberId,
            'check_in' => now(),
            'week_of' => $weekOf,
        ]);

        // return redirect()->route('attendance.showCheckinQr', $class_id)->with('success', 'Absensi berhasil dicatat untuk minggu ini!');
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
        $request->validate([
            'manual_checkins' => 'array',                   // Validasi bahwa input adalah array
            'manual_checkins.*' => 'exists:members,id',     // Pastikan setiap ID murid ada di tabel `members`
        ]);

        // Tentukan minggu aktif untuk absensi (mulai dari hari Minggu)
        // $weekOf = Carbon::now()->startOfWeek(Carbon::SUNDAY)->toDateString();
        $weekOf = Carbon::now()->toDateString();


        // Ambil ID admin yang melakukan checklist manual
        $adminId = Auth::user()->id; // Sesuaikan sesuai struktur data Anda

        foreach ($request->manual_checkins as $childId) {
            // Cek apakah murid sudah absen minggu ini
            $alreadyCheckedIn = SundaySchoolPresence::where('member_id', $childId)
                ->whereDate('week_of', $weekOf)
                ->exists();

            if (!$alreadyCheckedIn) {
                // Catat absensi baru di minggu aktif ini dengan `admin_checkin`
                SundaySchoolPresence::create([
                    'member_id' => $childId,
                    'check_in' => now(),
                    'week_of' => $weekOf,
                    'admin_check_in' => $adminId, // Isi kolom admin_check_in
                ]);
            }
        }

        return redirect()->route('attendance.classAttendance', $class_id)->with('success', 'Checklist manual berhasil disimpan untuk minggu ini!');
    }

}