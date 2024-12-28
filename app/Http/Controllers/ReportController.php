<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Report;
use App\Models\MemberScheduleMonthly;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class ReportController extends Controller
{
    //
    // List all reports for the admin
    public function index()
    {
        $reports = Report::with('sundaySchoolClass')->orderBy('week_of', 'desc')->paginate(10);
        return view('reports.index', compact('reports'));
    }

    public function indexForMentor()
    {
        // Dapatkan ID pembina dari user yang sedang login
        $mentorId = Auth::user()->member->id;

        // Ambil ID kelas yang sesuai dengan jadwal pembina
        $classIds = DB::table('member_schedule_monthly')
            ->join('schedules_sunday_school_class', 'member_schedule_monthly.schedules_sunday_school_class_id', '=', 'schedules_sunday_school_class.id')
            ->where('member_schedule_monthly.member_id', $mentorId)
            ->pluck('schedules_sunday_school_class.sunday_school_class_id');

        // Ambil week_of yang sesuai dengan jadwal pembina
        $validWeeks = DB::table('member_schedule_monthly')
            ->where('member_id', $mentorId)
            ->pluck('schedule_date');

        // Ambil laporan sesuai dengan kelas dan minggu yang valid
        $reports = Report::whereIn('sunday_school_class_id', $classIds)
            ->whereIn('week_of', $validWeeks)
            ->orderBy('week_of', 'desc')
            ->paginate(10);

        return view('reports.index', compact('reports'));
    }


    // Show the form to create a new report
    public function create()
    {
        // Ambil user yang sedang login
        /** @var \App\Models\User */
        $user = Auth::user();

        // Periksa apakah user adalah pembina
        if ($user->hasRole('Admin')) {
            $mentorId = $user->member->id; // Dapatkan ID member pembina

            // Ambil hanya kelas yang sesuai dengan jadwal pembina
            // Ambil hanya kelas yang sesuai dengan jadwal pembina
            $classes = DB::table('sunday_school_classes')
            ->join('schedules_sunday_school_class', 'sunday_school_classes.id', '=', 'schedules_sunday_school_class.sunday_school_class_id')
            ->join('member_schedule_monthly', 'schedules_sunday_school_class.id', '=', 'member_schedule_monthly.schedules_sunday_school_class_id')
            ->where('member_schedule_monthly.member_id', $mentorId)
            ->where('sunday_school_classes.status', 'Active')
            ->distinct()
            ->pluck('sunday_school_classes.name', 'sunday_school_classes.id');

            $weeksEndpoint = '/sunday-school/reports/get-valid-weeks-for-mentor';
        } else {
            // Jika bukan pembina (SuperAdmin), ambil semua kelas
            $classes = DB::table('sunday_school_classes')->where('status', 'Active')->pluck('name', 'id');
            // Endpoint untuk SuperAdmin
            $weeksEndpoint = '/sunday-school/reports/get-valid-weeks';
        }

        return view('reports.add', compact('classes', 'weeksEndpoint'));
    }


    
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'week_of' => 'required|date|exists:sunday_school_presences,week_of',
            'class_id' => 'required|exists:sunday_school_classes,id', // Validasi class_id
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:2048|mimes:pdf,docx,jpg,png',
        ]);

        $classId = $request->input('class_id');
        $weekOf = $request->input('week_of');

        // Cek apakah laporan untuk kelas dan minggu tersebut sudah ada
        $existingReport = Report::where('sunday_school_class_id', $classId)
                                ->where('week_of', $weekOf)
                                ->first();

        if ($existingReport) {
            return back()
                ->withErrors(['week_of' => 'Laporan untuk minggu ini sudah ada. Silakan pilih minggu lain.'])
                ->withInput();
        }

        // Simpan file jika ada
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('reports', 'public');
        }

        // Buat laporan baru
        Report::create([
            'week_of' => $weekOf,
            'sunday_school_class_id' => $classId,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'file_path' => $filePath,
        ]);

        return redirect()->route('admin.reports.index')->with('success', 'Laporan berhasil ditambahkan!');
    }
    
    public function show($id)
    {
        $report = Report::findOrFail($id);
        $classes = DB::table('sunday_school_classes')
                    ->where('status', 'Active')
                    ->pluck('name', 'id');

        return view('reports.show', compact('report', 'classes'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:2048|mimes:pdf,docx,jpg,png',
        ]);

        // Temukan laporan berdasarkan ID
        $report = Report::findOrFail($id);

        // Update data
        $report->title = $request->input('title');
        $report->description = $request->input('description');

        // Jika ada file baru, simpan file dan hapus file lama
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($report->file_path) {
                Storage::disk('public')->delete($report->file_path);
            }

            // Simpan file baru
            $report->file_path = $request->file('file')->store('reports', 'public');
        }

        $report->save();

        return redirect()->route('admin.reports.index')->with('success', 'Laporan berhasil diperbarui!');
    }


    // Download a report file
    public function download($id)
    {
        $report = Report::findOrFail($id);

        if ($report->file_path && Storage::exists('public/' . $report->file_path)) {
            $filePath = Storage::disk('public')->path($report->file_path);
            $fileName = basename($filePath);

            // Menggunakan mime_content_type() untuk mendapatkan MIME type file
            $mimeType = mime_content_type($filePath);

            return response()->stream(function () use ($filePath) {
                $handle = fopen($filePath, 'rb');
                fpassthru($handle);
                fclose($handle);
            }, 200, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="'.$fileName.'"',
            ]);
        }

        return back()->withErrors('File tidak ditemukan.');
    }

     

    // Delete a report
    public function destroy($id)
    {
        $report = Report::findOrFail($id);

        if ($report->file_path) {
            Storage::delete('public/' . $report->file_path);
        }

        $report->delete();

        return redirect()->route('admin.reports.index')->with('success', 'Laporan berhasil dihapus!');
    }

    public function getValidWeeks($classId)
    {
        // Ambil semua minggu yang memiliki absensi untuk kelas tertentu
        $weeks = DB::table('sunday_school_presences')
            ->join('sunday_school_members', 'sunday_school_presences.member_id', '=', 'sunday_school_members.member_id')
            ->where('sunday_school_members.sunday_school_class_id', $classId)
            ->distinct()
            ->pluck('week_of');

        return response()->json(['weeks' => $weeks]);
    }

    public function getValidWeeksForMentor($classId)
    {
        $mentorId = Auth::user()->member->id; // Ambil ID pembina yang sedang login


        $weeks = DB::table('member_schedule_monthly')
            ->join('schedules_sunday_school_class', 'member_schedule_monthly.schedules_sunday_school_class_id', '=', 'schedules_sunday_school_class.id')
            ->join('sunday_school_presences', 'member_schedule_monthly.schedule_date', '=', 'sunday_school_presences.week_of')
            ->join('sunday_school_members', 'sunday_school_presences.member_id', '=', 'sunday_school_members.member_id')
            ->where('member_schedule_monthly.member_id', $mentorId)
            ->where('schedules_sunday_school_class.sunday_school_class_id', $classId)
            ->where('sunday_school_members.sunday_school_class_id', $classId)
            ->distinct()
            ->pluck('member_schedule_monthly.schedule_date');

        return response()->json(['weeks' => $weeks]);
    }




}
