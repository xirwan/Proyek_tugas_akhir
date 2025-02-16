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
use App\Mail\ScheduleAssigned;
use Illuminate\Support\Facades\Mail;

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
        $members = Member::where('status', 'Active') // Filter hanya anggota dengan status Active
        ->whereHas('user', function ($query) {
            $query->role('Admin'); // Menggunakan Spatie untuk memfilter users dengan role 'Admin'
        })
        ->get();
        

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
            'month' => 'required|integer',
            'year' => 'required|integer|min:2024',
            'class_id' => 'required|exists:schedules_sunday_school_class,id',
            'member_id' => 'required|exists:members,id',
        ]);

        // Pemetaan nama bulan ke nomor
        $monthMap = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $monthNumber = $validated['month'];
        $year = $validated['year'];
        $classId = $validated['class_id'];
        $memberId = $validated['member_id'];

        // Cek validitas bulan
        if (!isset($monthMap[$monthNumber])) {
            return back()->withErrors(['month' => 'Bulan tidak valid.']);
        }

        $monthName = $monthMap[$monthNumber]; // Ubah menjadi integer bulan

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
        $startOfMonth = Carbon::create($year, $monthNumber, 1);
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
        $schedulesForEmail = [];  // Array untuk menampung semua jadwal bulan ini
        foreach ($dates as $date) {
            $schedule = MemberScheduleMonthly::create([
                'monthly_schedule_id' => $monthlySchedule->id,
                'schedules_sunday_school_class_id' => $scheduleClass->id,
                'member_id' => $memberId,
                'schedule_date' => $date
            ]);
            $schedulesForEmail[] = $schedule;
        }
        $memberemail = Member::find($memberId);
        $email = $memberemail->user->email;
        // Kirim email kepada member yang dijadwalkan
        Mail::to($email)->send(new ScheduleAssigned($schedulesForEmail));

        return redirect()->route('scheduling.index')->with('success', 'Data Penjadwalan Berhasil Disimpan!');
    }

    
    public function create(Request $request)
    {
        // Ambil tahun dan bulan dari request atau default ke tahun saat ini
        $selectedYear = $request->input('year', now()->year);
        $selectedMonth = $request->input('month');

        // Definisikan bulan dengan nama
        $monthOptions = collect([
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ])->filter(function ($monthName, $monthNumber) use ($selectedYear) {
            $currentMonth = now()->month;
            $currentYear = now()->year;
            if ($selectedYear > $currentYear) {
                return true; // Semua bulan tersedia untuk tahun mendatang
            } elseif ($selectedYear == $currentYear) {
                return $monthNumber >= $currentMonth; // Bulan yang belum lewat
            } else {
                return true; // Sesuaikan jika ingin membatasi untuk tahun lalu
            }
        });

        // Validasi selectedMonth
        if ($selectedMonth && !$monthOptions->has($selectedMonth)) {
            $selectedMonth = null; // Menghapus bulan yang tidak valid
        }

        // Jika selectedMonth tidak ada, set ke bulan pertama yang tersedia
        if (!$selectedMonth && $monthOptions->isNotEmpty()) {
            $selectedMonth = $monthOptions->keys()->first();
        }

        // Mendapatkan ID Member yang sudah dijadwalkan pada bulan dan tahun yang dipilih berdasarkan schedule_date
        $scheduledMemberIds = MemberScheduleMonthly::whereYear('schedule_date', $selectedYear)
            ->when($selectedMonth, function ($query, $month) {
                return $query->whereMonth('schedule_date', $month);
            })
            ->pluck('member_id')
            ->unique()
            ->toArray();

        // Mendapatkan ID Kelas yang sudah dijadwalkan pada bulan dan tahun yang dipilih berdasarkan schedule_date
        $scheduledClassIds = MemberScheduleMonthly::whereYear('schedule_date', $selectedYear)
            ->when($selectedMonth, function ($query, $month) {
                return $query->whereMonth('schedule_date', $month);
            })
            ->pluck('schedules_sunday_school_class_id')
            ->unique()
            ->toArray();

        // Mendapatkan opsi member yang belum dijadwalkan
        $memberOptions = Member::where('status', 'Active') // Hanya ambil anggota dengan status Active
            ->whereHas('user', function ($query) {
                $query->role('Admin'); // Filter user dengan role 'Admin' menggunakan Spatie
            })
            ->whereNotIn('id', $scheduledMemberIds) // Kecualikan anggota yang ada di $scheduledMemberIds
            ->get()
            ->mapWithKeys(function ($member) {
                return [$member->id => $member->firstname . ' ' . $member->lastname];
            });

        // Mendapatkan opsi kelas yang belum dijadwalkan
        $scheduleClassOptions = ScheduleSundaySchoolClass::whereNotIn('schedules_sunday_school_class.id', $scheduledClassIds)
            ->join('schedules', 'schedules.id', '=', 'schedules_sunday_school_class.schedule_id')
            ->join('sunday_school_classes', 'sunday_school_classes.id', '=', 'schedules_sunday_school_class.sunday_school_class_id')
            ->select(
                'schedules_sunday_school_class.id',
                DB::raw("CONCAT(sunday_school_classes.name, ' - ', schedules.day) as name")
            )
            ->pluck('name', 'schedules_sunday_school_class.id');

        // Jika tidak ada bulan yang tersedia, tampilkan pesan error
        if (!$selectedMonth) {
            return redirect()->route('scheduling.create')->with('error', 'Tidak ada bulan yang tersedia untuk tahun yang dipilih.');
        }

        return view('scheduling.add', compact('monthOptions', 'memberOptions', 'scheduleClassOptions', 'selectedMonth', 'selectedYear'));
    }

    public function edit($id)
    {
        $schedule = MemberScheduleMonthly::with(['monthlySchedule', 'member'])->findOrFail($id);

        // Ambil bulan dan tahun dari jadwal
        $month = $schedule->monthlySchedule->month;
        $year = $schedule->monthlySchedule->year;

        // Ambil ID pembina yang sudah dijadwalkan di bulan dan tahun yang sama
        $scheduledMemberIds = MemberScheduleMonthly::whereHas('monthlySchedule', function ($query) use ($month, $year) {
            $query->where('month', $month)->where('year', $year);
        })->pluck('member_id')->unique()->toArray();

        // Masukkan pembina yang sedang dijadwalkan agar tetap muncul di dropdown
        if (($key = array_search($schedule->member_id, $scheduledMemberIds)) !== false) {
            unset($scheduledMemberIds[$key]);
        }

        // Ambil daftar pembina yang belum dijadwalkan di bulan dan tahun tersebut
        $members = Member::whereHas('user', function ($query) {
            $query->role('Admin'); // Menggunakan Spatie untuk memfilter user dengan role 'admin'
        })->whereNotIn('id', $scheduledMemberIds)->get();

        return view('scheduling.edit', compact('schedule', 'members'));
    }

    public function update(Request $request, $id)
    {
        $schedule = MemberScheduleMonthly::findOrFail($id);

        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
        ]);

        // Perbarui pembina
        $schedule->update([
            'member_id' => $validated['member_id'],
        ]);

        return redirect()->route('scheduling.index')->with('success', 'Jadwal berhasil diperbarui!');
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

        // Pemetaan bulan bahasa Inggris ke bahasa Indonesia
        $monthNamesInIndonesian = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember'
        ];

        // Ambil bulan dan tahun saat ini jika tidak ada input bulan dari pengguna
        $monthInput = $request->input('month', Carbon::now()->format('F')); // Default ke bulan saat ini dalam bahasa Inggris
        $year = $request->input('year', now()->year); // Default ke tahun saat ini

        // Map bulan yang diinput dari bahasa Inggris ke bahasa Indonesia
        $monthInputIndonesian = $monthNamesInIndonesian[$monthInput] ?? 'Januari';  // Default 'Januari' jika bulan tidak valid

        // Query untuk mengambil jadwal sesuai member_id, bulan (nama), dan tahun
        $query = MemberScheduleMonthly::where('member_id', $memberId)
            ->whereHas('monthlySchedule', function ($query) use ($monthInputIndonesian, $year) {
                $query->where('month', $monthInputIndonesian) // Menggunakan nama bulan dalam bahasa Indonesia
                    ->where('year', $year);
            });

        // Ambil data jadwal dengan paginasi
        $schedules = $query->with([
            'monthlySchedule',
            'scheduleSundaySchoolClass.sundaySchoolClass',
            'scheduleSundaySchoolClass.schedule' // Tambahkan relasi untuk jam dan hari
        ])->paginate(10);

        // Daftar nama bulan untuk filter (gunakan nama bulan dalam bahasa Indonesia)
        $months = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
        ];

        return view('scheduling.indexpembina', compact('schedules', 'months'));
    }

}
