<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Schedule;
use App\Models\Category;
use App\Models\Type;
use Carbon\Carbon;
use App\Models\MemberScheduleMonthly;

class ScheduleController extends Controller
{
    //
    public function index() : View
    {   
        $schedules = Schedule::with(['type', 'category'])
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
            ")->paginate(10);

        return view('schedule.index', compact('schedules'));

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
        ]);

        // Cari jadwal berdasarkan ID
        $schedule = Schedule::findOrFail($id);

        // Simpan hari lama sebelum update
        $oldDay = $schedule->day;

        // Update jadwal dengan nilai baru
        $schedule->update([
            'name'          => $request->input('name'),
            'description'   => $request->input('description'),
            'day'           => $request->input('day'),
            'start'         => $request->input('start', $schedule->start),
            'end'           => $request->input('end', $schedule->end),
            'status'        => 'Active',
            'category_id'   => $request->input('category_id'),
            'type_id'       => $request->input('type_id'),
        ]);

        // Jika hari berubah, perbarui penjadwalan anggota
        if ($oldDay !== $request->input('day')) {
            // Pemetaan hari Indonesia ke format bahasa Inggris (untuk Carbon)
            $dayMap = [
                'Senin'    => 'Monday',
                'Selasa'   => 'Tuesday',
                'Rabu'     => 'Wednesday',
                'Kamis'    => 'Thursday',
                'Jumat'    => 'Friday',
                'Sabtu'    => 'Saturday',
                'Minggu'   => 'Sunday',
            ];

            // Tentukan hari baru dan hari lama dalam format bahasa Inggris
            $newDay = $dayMap[$request->input('day')];
            $oldDay = $dayMap[$oldDay];

            // Ambil semua kelas (SundaySchoolClass) yang terkait dengan jadwal ini
            $scheduleClasses = $schedule->classes; // Mengambil koleksi kelas yang terkait dengan jadwal

            // Loop melalui setiap kelas yang terkait dan perbarui MemberScheduleMonthly
            foreach ($scheduleClasses as $scheduleClass) {
                // Ambil semua penjadwalan anggota untuk kelas ini
                $memberSchedules = MemberScheduleMonthly::where('schedules_sunday_school_class_id', $scheduleClass->pivot->id)->get();

                foreach ($memberSchedules as $memberSchedule) {
                    // Parsing tanggal jadwal lama
                    $oldScheduleDate = Carbon::parse($memberSchedule->schedule_date);

                    // Cari tanggal berikutnya untuk hari baru (misalnya, Senin ke Selasa)
                    $newScheduleDate = $oldScheduleDate->copy()->next($newDay); // Mendapatkan tanggal yang sesuai dengan hari baru

                    // Perbarui tanggal jadwal untuk anggota
                    $memberSchedule->update([
                        'schedule_date' => $newScheduleDate->toDateString(),
                    ]);
                }
            }
        }

        // Mengembalikan pesan sukses setelah berhasil diubah
        return redirect()->route('schedule.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy($encryptedId): RedirectResponse
    {
        $id = decrypt($encryptedId);
        //get product by ID
        $schedule = Schedule::findOrFail($id);

        //delete product
        $schedule->delete();

        //redirect to index
        return redirect()->route('schedule.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }

}