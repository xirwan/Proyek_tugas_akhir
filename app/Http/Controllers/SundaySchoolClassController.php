<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Models\SundaySchoolClass;
use App\Models\Member;
use App\Models\Schedule;
use Illuminate\Http\Request;

class SundaySchoolClassController extends Controller
{
    // 1. Menampilkan daftar kelas
    public function index()
    {
        $classes = SundaySchoolClass::paginate(3);
        return view('sundayclasses.index', compact('classes'));
    }

    // 2. Menampilkan form untuk membuat kelas baru
    public function create()
    {
        $schedules = Schedule::all();
        return view('sundayclasses.add', compact('schedules'));
    }

    // 3. Menyimpan kelas baru ke database
    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'schedule_id' => 'required|exists:schedules,id', // Validasi jadwal harus ada
        ]);

        $class = SundaySchoolClass::create([
            'name'                  => $request->input('name'),
            'description'           => $request->input('description'),
            'status'                => 'Active',
        ]);

        // Hubungkan kelas dengan jadwal melalui tabel pivot
        $class->schedules()->attach($request->input('schedule_id'));

        return redirect()->route('sunday-classes.index')->with('success', 'Data Berhasil Disimpan!');
    }

    // 4. Menampilkan detail kelas (opsional)
    public function show($encryptedId)
    {
        $id = decrypt($encryptedId);
        $class = SundaySchoolClass::findOrFail($id);
        $schedules = Schedule::all();
        return view('sundayclasses.show', compact('class', 'schedules'));
    }

    // 5. Menampilkan form untuk mengedit kelas
    public function edit($encryptedId)
    {
        $id = decrypt($encryptedId);
        $class = SundaySchoolClass::findOrFail($id);
        return view('sundayclasses.edit', compact('class'));
    }

    // 6. Memperbarui data kelas
    public function update(Request $request, $encryptedId)
    {
        $id = decrypt($encryptedId);
        $request->validate([
            'name'              => 'required|string|max:255',
            'description'       => 'nullable|string',
            'status'            => 'required|in:Active,Inactive',
            'schedule_id'       => 'required|exists:schedules,id', // Validasi jadwal harus ada
        ]);

        $class = SundaySchoolClass::findOrFail($id);
        $class->update([
            'name'              => $request->input('name'),
            'description'       => $request->input('description'),
            'status'            => $request->input('status'),
        ]);

        // Perbarui relasi jadwal
        $class->schedules()->sync([$request->input('schedule_id')]);

        return redirect()->route('sunday-classes.index')->with('success', 'Data Berhasil Diperbarui!');
    }

    // 7. Menghapus kelas
    public function destroy($encryptedId)
    {
        $id = decrypt($encryptedId);
        $class = SundaySchoolClass::findOrFail($id);
        $class->delete();

        return redirect()->route('sundayclasses.index')->with('success', 'Data Berhasil Dihapus!');
    }

    // 8. untuk menampilkan list anak yang terdaftar pada kelas
    public function viewClassStudents($encryptedId)
    {
        $classId = decrypt($encryptedId);
        // Dapatkan kelas berdasarkan ID
        $class = SundaySchoolClass::findOrFail($classId);

        // Ambil semua murid yang terdaftar di kelas ini melalui relasi many-to-many
        $students = $class->members()->paginate(10);

        // Kembali ke view dengan data kelas dan murid
        return view('sundayclasses.class-students', [
            'class' => $class,
            'students' => $students,
        ]);
    }

    public function showAdjustClassForm($encryptedId)
    {
        $childId = decrypt($encryptedId);

        // Ambil data anak berdasarkan ID
        $child = Member::findOrFail($childId);

        // Ambil daftar semua kelas sekolah minggu dengan pluck untuk siap digunakan di view
        $classes = SundaySchoolClass::pluck('name', 'id');

        // Kembalikan view dengan data anak dan kelas
        return view('sundayclasses.adjust-class', [
            'child' => $child,
            'classes' => $classes,
        ]);
    }

    public function adjustClass(Request $request, $encryptedId)
    {
        $request->validate([
            'class_id' => 'required|exists:sunday_school_classes,id',
        ]);

        $childId = decrypt($encryptedId);
        // Temukan anak berdasarkan ID
        $child = Member::findOrFail($childId);

        // Sinkronkan kelas baru pada tabel pivot sunday_school_members
        $child->sundaySchoolClasses()->sync([$request->class_id]);

        return redirect()->route('sundayschoolclass.viewClassStudents', encrypt($request->class_id))
            ->with('success', 'Kelas anak berhasil diperbarui!');
    }

}