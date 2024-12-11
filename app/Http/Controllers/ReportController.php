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

}
