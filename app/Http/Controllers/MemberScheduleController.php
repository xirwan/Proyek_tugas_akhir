<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MonthlySchedule;
use App\Models\ScheduleSundaySchoolClass;
use App\Models\MemberScheduleMonthly;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;

class MemberScheduleController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter filter dari request
        $month = $request->input('month'); // Bulan (string)
        $memberId = $request->input('member_id'); // Pembina (member_id)

        // Query dasar untuk MemberScheduleMonthly
        $query = MemberScheduleMonthly::query()
        ->with([
            'monthlySchedule',
            'scheduleSundaySchoolClass.sundaySchoolClass', // Eager load nama kelas
            'member'
        ]);
    

        // Filter berdasarkan bulan dan tahun jika ada
        if ($month) {
            $query->whereHas('monthlySchedule', function ($q) use ($month) {
                $q->where('month', $month);
            });
        }

        // Filter berdasarkan pembina (member_id) jika ada
        if ($memberId) {
            $query->where('member_id', $memberId);
        }

        // Ambil data pembina yang memiliki posisi tertentu
        $members = Member::whereHas('user', function ($query) {
            $query->role('Admin'); // Menggunakan Spatie untuk memfilter users dengan role 'admin'
        })->get();
        

        // Ambil daftar bulan untuk dropdown
        $months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        // Ambil hasil dengan pagination
        $schedules = $query->paginate(10); // Menampilkan 10 data per halaman

        return view('scheduling.index', compact('schedules', 'members', 'months', 'month', 'memberId'));
    }

    //
    /**
     * Tambahkan Penjadwalan Bulanan Beserta Jadwal Pembina
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'month' => 'required|string',
            'year' => 'required|integer|min:2024',
            'class_id' => 'required|exists:schedules_sunday_school_class,id',
            'member_id' => 'required|exists:members,id',
        ]);

        // Pemetaan nama bulan ke nomor
        $monthMap = [
            'Januari' => 1,
            'Februari' => 2,
            'Maret' => 3,
            'April' => 4,
            'Mei' => 5,
            'Juni' => 6,
            'Juli' => 7,
            'Agustus' => 8,
            'September' => 9,
            'Oktober' => 10,
            'November' => 11,
            'Desember' => 12,
        ];

        $monthName = $validated['month'];
        $year = $validated['year'];
        $classId = $validated['class_id'];
        $memberId = $validated['member_id'];

        if (!isset($monthMap[$monthName])) {
            return back()->withErrors(['month' => 'Bulan tidak valid.']);
        }

        $month = $monthMap[$monthName]; // Ubah menjadi integer bulan

        // Ambil hari dari jadwal kelas
        $scheduleClass = ScheduleSundaySchoolClass::findOrFail($classId);
        $schedule = $scheduleClass->schedule; 
        $dayName = $schedule->day;
        $dayMap = [
            'Senin' => 'Monday',
            'Selasa' => 'Tuesday',
            'Rabu' => 'Wednesday',
            'Kamis' => 'Thursday',
            'Jumat' => 'Friday',
            'Sabtu' => 'Saturday',
            'Minggu' => 'Sunday',
        ];
        $dayName = $dayMap[$dayName] ?? $dayName;

        // Cek atau buat MonthlySchedule
        $monthlySchedule = MonthlySchedule::firstOrCreate([
            'month' => $monthName,
            'year' => $year
        ]);

        // Generate semua tanggal
        $startOfMonth = Carbon::create($year, $month, 1);
        $endOfMonth = $startOfMonth->copy()->endOfMonth();

        $dates = [];
        $currentDate = $startOfMonth->copy();
        while ($currentDate->lessThanOrEqualTo($endOfMonth)) {
            if ($currentDate->format('l') === $dayName) {
                $dates[] = $currentDate->toDateString();
            }
            $currentDate->addDay();
        }

        // Validasi jika sudah ada penjadwalan untuk member pada tanggal yang sama
        foreach ($dates as $date) {
            $existingSchedule = MemberScheduleMonthly::where('member_id', $memberId)
                ->where('schedule_date', $date)
                ->first();

            if ($existingSchedule) {
                return back()->withErrors(['member_id' => "Member sudah memiliki penjadwalan untuk tanggal $date."]);
            }
        }

        // Simpan data penjadwalan
        foreach ($dates as $date) {
            MemberScheduleMonthly::create([
                'monthly_schedule_id' => $monthlySchedule->id,
                'schedules_sunday_school_class_id' => $scheduleClass->id,
                'member_id' => $memberId,
                'schedule_date' => $date
            ]);
        }

        return redirect()->route('scheduling.index')->with('success', 'Data Penjadwalan Berhasil Disimpan!');
    }

    /**
     * Tampilkan Form Penjadwalan Bulanan
     */
    public function create()
    {
        // Ambil data untuk dropdown
        $monthOptions = [
            'Januari' => 'Januari',
            'Februari' => 'Februari',
            'Maret' => 'Maret',
            'April' => 'April',
            'Mei' => 'Mei',
            'Juni' => 'Juni',
            'Juli' => 'Juli',
            'Agustus' => 'Agustus',
            'September' => 'September',
            'Oktober' => 'Oktober',
            'November' => 'November',
            'Desember' => 'Desember',
        ];

        $memberOptions = Member::whereHas('user', function ($query) {
            $query->role('admin'); // Menggunakan Spatie untuk memfilter user dengan role 'admin'
        })->get()->mapWithKeys(function ($member) {
            return [$member->id => $member->firstname . ' ' . $member->lastname]; // Gabungkan nama depan dan belakang
        });        

        $scheduleClassOptions = DB::table('schedules_sunday_school_class')
            ->join('schedules', 'schedules.id', '=', 'schedules_sunday_school_class.schedule_id')
            ->join('sunday_school_classes', 'sunday_school_classes.id', '=', 'schedules_sunday_school_class.sunday_school_class_id')
            ->select(
                'schedules_sunday_school_class.id',
                DB::raw("CONCAT(sunday_school_classes.name, ' - ', schedules.day) as name")
            )
            ->pluck('name', 'id'); // Pilihan kelas & jadwal
        return view('scheduling.add', compact('monthOptions', 'memberOptions', 'scheduleClassOptions'));
    }

    public function mySchedule(Request $request)
    {
        $user = Auth::user(); // Mendapatkan data pengguna yang sedang login

        // Cari member_id berdasarkan user_id
        $member = Member::where('user_id', $user->id)->first();

        if (!$member) {
            // Jika tidak ditemukan member terkait dengan user, tampilkan pesan kesalahan
            return redirect()->back()->withErrors(['error' => 'Anda belum terdaftar sebagai pembina.']);
        }

        $memberId = $member->id;

        // Validasi filter bulan (opsional)
        $month = $request->input('month');
        $query = MemberScheduleMonthly::where('member_id', $memberId);

        // Filter berdasarkan bulan jika dipilih
        if ($month) {
            $query->whereHas('monthlySchedule', function ($query) use ($month) {
                $query->where('month', $month);
            });
        }

        // Ambil data jadwal dengan paginasi
        $schedules = $query->with([
            'monthlySchedule',
            'scheduleSundaySchoolClass.sundaySchoolClass',
            'scheduleSundaySchoolClass.schedule' // Tambahkan relasi untuk jam dan hari
        ])->paginate(10);

        // Daftar nama bulan untuk filter
        $months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        return view('scheduling.indexpembina', compact('schedules', 'months'));
    }


}
