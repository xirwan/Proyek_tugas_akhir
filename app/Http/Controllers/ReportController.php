<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Report;
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

    // Show the form to create a new report
    public function create()
    {
        // Retrieve all distinct week_of values from sunday_school_presences for dropdown
        // $weeks = DB::table('sunday_school_presences')->distinct()->pluck('week_of','week_of')->toArray();
        // Ambil semua kelas sekolah minggu
        $classes = DB::table('sunday_school_classes')->where('status', 'Active')->pluck('name', 'id');
        return view('reports.add', compact('classes'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'week_of' => 'required|date|exists:sunday_school_presences,week_of',
            'class_id' => 'required|exists:sunday_school_classes,id', // Validasi class_id
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:2048|mimes:pdf,docx,jpg,png',
        ]);
    
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('reports', 'public');
        }
    
        Report::create([
            'week_of' => $request->input('week_of'),
            'sunday_school_class_id' => $request->input('class_id'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'file_path' => $filePath,
        ]);
    
        return redirect()->route('admin.reports.index')->with('success', 'Laporan berhasil ditambahkan!');
    }    

     // Download a report file
    public function download($id)
    {
        $report = Report::findOrFail($id);

        if ($report->file_path && Storage::exists('public/' . $report->file_path)) {
            return Storage::download('public/' . $report->file_path);
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

    

}
