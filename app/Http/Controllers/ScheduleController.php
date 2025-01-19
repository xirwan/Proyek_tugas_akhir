<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Schedule;
use App\Models\Category;
use App\Models\Type;
use App\Models\AttendanceMember;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\MemberScheduleMonthly;

class ScheduleController extends Controller
{
    //
    public function index(Request $request) : View
    {
        // Ambil filter status dari request
        $filterStatus = $request->query('status');

        // Query jadwal dengan urutan hari
        $query = Schedule::with(['type', 'category'])
            ->orderByRaw("
                CASE 
                    WHEN day = 'Senin' THEN 1
                    WHEN day = 'Selasa' THEN 2
                    WHEN day = 'Rabu' THEN 3
                    WHEN day = 'Kamis' THEN 4
                    WHEN day = 'Jumat' THEN 5
                    WHEN day = 'Sabtu' THEN 6
                    WHEN day = 'Minggu' THEN 7
                END
            ");

        // Tambahkan filter status jika ada
        if ($filterStatus) {
            $query->where('status', $filterStatus);
        }

        $schedules = $query->paginate(10);

        return view('schedule.index', compact('schedules', 'filterStatus'));
    }

    public function indexMember(Request $request) : View
    {
        // Ambil filter status dari request
        $filterStatus = $request->query('status');

        // Query jadwal dengan urutan hari
        $query = Schedule::with(['type', 'category'])
            ->orderByRaw("
                CASE 
                    WHEN day = 'Senin' THEN 1
                    WHEN day = 'Selasa' THEN 2
                    WHEN day = 'Rabu' THEN 3
                    WHEN day = 'Kamis' THEN 4
                    WHEN day = 'Jumat' THEN 5
                    WHEN day = 'Sabtu' THEN 6
                    WHEN day = 'Minggu' THEN 7
                END
            ");

        // Tambahkan filter status jika ada
        if ($filterStatus) {
            $query->where('status', $filterStatus);
        }

        $schedules = $query->paginate(10);

        return view('schedule.memberindex', compact('schedules', 'filterStatus'));
    }


    public function create() : View
    {
        $categories = Category::where('status', 'Active')->get();

        $categoryoptions = $categories->pluck('name', 'id');

        $types = Type::where('status', 'Active')->get();

        $typeoptions = $types->pluck('name', 'id');

        return view('schedule.add', compact('categoryoptions', 'typeoptions'));
    }

    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'name'          => 'required|string',
            'description'   => 'required|string',
            'day'           => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'start'         => 'required|date_format:H:i',
            'end'           => 'nullable|date_format:H:i',
            'category_id'   => 'required|exists:categories,id',
            'type_id'       => 'required|exists:types,id',
        ]);

        Schedule::create([
            'name'                  => $request->input('name'),
            'description'           => $request->input('description'),
            'day'                   => $request->input('day'),
            'start'                 => $request->input('start'),
            'end'                   => $request->input('end'),
            'status'                => 'Active',
            'category_id'           => $request->input('category_id'),
            'type_id'               => $request->input('type_id'),

        ]);

        return redirect()->route('schedule.index')->with(['success' => 'Data Berhasil Disimpan!']);

    }

    public function show($encryptedId) : View
    {  
        $id = decrypt($encryptedId);

        $schedule = Schedule::findOrFail($id);

        $dayoptions = [
            'Senin' => 'Senin',
            'Selasa' => 'Selasa',
            'Rabu' => 'Rabu',
            'Kamis' => 'Kamis',
            'Jumat' => 'Jumat',
            'Sabtu' => 'Sabtu',
            'Minggu' => 'Minggu'
        ];

        $types = Type::where('status', 'Active')->get();

        $typeoptions = $types->pluck('name', 'id');

        $categories = Category::where('status', 'Active')->get();

        $categoryoptions = $categories->pluck('name', 'id');

        //render view with product
        return view('schedule.show', compact('schedule', 'dayoptions', 'typeoptions', 'categoryoptions'));
    }

    public function update(Request $request, $encryptedId) : RedirectResponse
    {
        $id = decrypt($encryptedId);

        // Format waktu mulai dan selesai
        $request->merge([
            'start' => \Carbon\Carbon::parse($request->input('start'))->format('H:i'),
            'end' => $request->input('end') ? \Carbon\Carbon::parse($request->input('end'))->format('H:i') : null,
        ]);

        // Validasi data input
        $request->validate([
            'name'          => 'required|string',
            'description'   => 'required|string',
            'day'           => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'start'         => ['required', 'date_format:H:i'],
            'end'           => ['nullable', 'date_format:H:i'],
            'category_id'   => 'required|exists:categories,id',
            'type_id'       => 'required|exists:types,id',
            'status'            => 'required|in:Active,Inactive',
        ]);

        // Cari jadwal berdasarkan ID
        $schedule = Schedule::findOrFail($id);

        if ($request->input('status') === 'Inactive' && $schedule->classes()->exists()) {
            return redirect()->back()->with([
                'error' => 'Jadwal tidak dapat dinonaktifkan karena masih terkait dengan kelas.'
            ]);
        }

        // Update jadwal dengan nilai baru
        $schedule->update([
            'name'          => $request->input('name'),
            'description'   => $request->input('description'),
            'day'           => $request->input('day'),
            'start'         => $request->input('start', $schedule->start),
            'end'           => $request->input('end', $schedule->end),
            'status'        => $request->input('status'),
            'category_id'   => $request->input('category_id'),
            'type_id'       => $request->input('type_id'),
        ]);


        // Mengembalikan pesan sukses setelah berhasil diubah
        return redirect()->route('schedule.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy($encryptedId): RedirectResponse
    {
        $id = decrypt($encryptedId);

        // Cari jadwal berdasarkan ID
        $schedule = Schedule::findOrFail($id);

        // Periksa apakah jadwal masih terkait dengan kelas
        if ($schedule->classes()->exists()) {
            return redirect()->back()->with([
                'error' => 'Jadwal tidak dapat dinonaktifkan karena masih terkait dengan kelas.'
            ]);
        }

        // Ubah status menjadi 'Inactive'
        $schedule->update([
            'status' => 'Inactive',
        ]);

        return redirect()->route('schedule.index')->with([
            'success' => 'Jadwal berhasil dinonaktifkan!'
        ]);
    }

    public function activate($encryptedId): RedirectResponse
    {
        $id = decrypt($encryptedId);

        // Cari jadwal berdasarkan ID
        $schedule = Schedule::findOrFail($id);

        // Ubah status menjadi 'Active'
        $schedule->update([
            'status' => 'Active',
        ]);

        return redirect()->route('schedule.index')->with([
            'success' => 'Jadwal berhasil diaktifkan kembali!'
        ]);
    }

    public function generateQRCode(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);

        // Pastikan direktori untuk menyimpan QR code ada
        $qrDirectory = storage_path("app/public/qr_code_schedules");
        if (!file_exists($qrDirectory)) {
            mkdir($qrDirectory, 0755, true);
        }

        // Generate QR code
        $qrPath = "qr_code_schedules/schedule_{$id}.png";
        QrCode::format('png')
            ->size(300)
            ->generate($schedule->id, storage_path("app/public/{$qrPath}"));

        // Simpan path ke database
        $schedule->update(['qr_code_path' => $qrPath]);

        return redirect()->back()->with('success', 'QR Code berhasil di-generate.');
    }

    public function showMemberScan()
    {
        return view('scan');
    }

    public function checkin(Request $request)
    {
        $scheduleId = $request->input('schedule_id');

        // Ambil member_id dari user yang login
        $memberId = Auth::user()->member->id; // Pastikan relasi user -> member ada di model User

        // Validasi jadwal
        $schedule = Schedule::find($scheduleId);
        if (!$schedule) {
            return redirect()->back()->withErrors('QR Code tidak valid.');
        }

        // Validasi hari
        $currentDay = now()->format('l'); // Hari saat ini dalam bahasa Inggris
        $dayMapping = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        if ($dayMapping[$currentDay] !== $schedule->day) {
            return redirect()->back()->withErrors('Hari ini bukan jadwal yang sesuai.');
        }

        // Validasi waktu
        $currentTime = now();
        $startTime = \Carbon\Carbon::parse($schedule->start);
        $endTime = \Carbon\Carbon::parse($schedule->end);

        if ($currentTime->lt($startTime) || $currentTime->gt($endTime)) {
            return redirect()->back()->withErrors('Absensi hanya dapat dilakukan dalam waktu yang ditentukan.');
        }

        // Validasi absensi minggu ini
        $currentWeekStart = now()->startOfWeek();
        $currentWeekEnd = now()->endOfWeek();

        $alreadyCheckedIn = AttendanceMember::where('schedule_id', $scheduleId)
            ->where('member_id', $memberId)
            ->whereBetween('scanned_at', [$currentWeekStart, $currentWeekEnd])
            ->exists();

        if ($alreadyCheckedIn) {
            return redirect()->back()->withErrors('Anda sudah melakukan absensi untuk minggu ini.');
        }

        // Simpan absensi
        AttendanceMember::create([
            'schedule_id' => $scheduleId,
            'member_id' => $memberId,
            'scanned_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Absensi berhasil dicatat.');
    }


    public function viewMemberAttendance()
    {
        $memberId = Auth::user()->member->id; // Ambil ID member dari user yang login

        // Ambil riwayat absensi member
        $attendanceRecords = AttendanceMember::where('member_id', $memberId)
            ->with('schedule') // Relasi ke jadwal
            ->orderBy('scanned_at', 'desc')
            ->get();

    
        return view('history', compact('attendanceRecords'));
    }

    public function manualCheckin($scheduleId)
    {
        // Ambil jadwal
        $schedule = Schedule::findOrFail($scheduleId);

        // Ambil semua member
        $members = Member::whereHas('user.roles', function ($query) {
            $query->where('name', 'JemaatRemaja');
        })->paginate(10);

        // Tentukan rentang minggu ini
        $currentWeekStart = now()->startOfWeek();
        $currentWeekEnd = now()->endOfWeek();

        // Ambil absensi minggu ini untuk jadwal tertentu
        $attendanceRecords = AttendanceMember::where('schedule_id', $scheduleId)
            ->whereBetween('scanned_at', [$currentWeekStart, $currentWeekEnd])
            ->get();

        // Kirim data ke view
        return view('manual_checkin', compact('schedule', 'members', 'attendanceRecords'));
    }

    public function storeManualCheckin(Request $request, $scheduleId)
    {
        // Ambil jadwal
        $schedule = Schedule::findOrFail($scheduleId);

        // Ambil ID member yang di-checklist
        $checkedMembers = $request->input('member_ids', []);

        // Tentukan rentang minggu ini
        $currentWeekStart = now()->startOfWeek();
        $currentWeekEnd = now()->endOfWeek();

        // Simpan absensi manual untuk setiap member yang di-checklist
        foreach ($checkedMembers as $memberId) {
            // Pastikan absensi belum tercatat minggu ini
            $alreadyCheckedIn = AttendanceMember::where('schedule_id', $scheduleId)
                ->where('member_id', $memberId)
                ->whereBetween('scanned_at', [$currentWeekStart, $currentWeekEnd])
                ->exists();

            if (!$alreadyCheckedIn) {
                AttendanceMember::create([
                    'schedule_id' => $scheduleId,
                    'member_id' => $memberId,
                    'scanned_at' => now(),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Absensi manual berhasil diperbarui.');
    }

    public function indexAttendance(Request $request) : View
    {
        // Ambil filter status dari request
        $filterStatus = $request->query('status');

        // Query jadwal dengan urutan hari
        $query = Schedule::with(['type', 'category'])
            ->orderByRaw("
                CASE 
                    WHEN day = 'Senin' THEN 1
                    WHEN day = 'Selasa' THEN 2
                    WHEN day = 'Rabu' THEN 3
                    WHEN day = 'Kamis' THEN 4
                    WHEN day = 'Jumat' THEN 5
                    WHEN day = 'Sabtu' THEN 6
                    WHEN day = 'Minggu' THEN 7
                END
            ");

        // Tambahkan filter status jika ada
        if ($filterStatus) {
            $query->where('status', $filterStatus);
        }

        $schedules = $query->paginate(10);

        return view('attendance', compact('schedules', 'filterStatus'));
    }

    public function showForm($id)
    {
        $schedule = Schedule::findOrFail($id); // Ambil data jadwal berdasarkan ID
        return view('report-form', compact('schedule')); // Kirim data ke view
    }

    public function generateReport(Request $request)
    {
        // Validasi input rentang waktu
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Ambil data sesuai rentang waktu
        $attendances = \App\Models\AttendanceMember::with(['schedule', 'member'])
            ->whereBetween('scanned_at', [$request->start_date, $request->end_date])
            ->get();

        // Generate PDF
        $pdf = PDF::loadView('report', compact('attendances', 'request'));

        // Return PDF untuk ditampilkan di halaman baru
        return $pdf->stream('Laporan_Kegiatan.pdf');
    }


}