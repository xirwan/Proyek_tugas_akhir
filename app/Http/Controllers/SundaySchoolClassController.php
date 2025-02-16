<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Models\SundaySchoolClass;
use App\Models\Member;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SundaySchoolClassController extends Controller
{
    // 1. Menampilkan daftar kelas
    public function index(Request $request): View
    {
        // Ambil filter status dari query parameter
        $filterStatus = $request->query('status');

        // Query dengan filter status jika diberikan
        $query = SundaySchoolClass::query();

        if ($filterStatus) {
            $query->where('status', $filterStatus);
        }

        $classes = $query->paginate(10);

        return view('sundayclasses.index', compact('classes', 'filterStatus'));
    }


    // 2. Menampilkan form untuk membuat kelas baru
    public function create()
    {
        $schedules = Schedule::where('status', 'Active')->get();
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
        $selectedSchedules = $class->schedules->first()->id;
        return view('sundayclasses.show', compact('class', 'schedules', 'selectedSchedules'));
    }

    // 5. Menampilkan form untuk mengedit kelas
    public function edit($encryptedId)
    {
        $id = decrypt($encryptedId);
        $class = SundaySchoolClass::findOrFail($id);
        return view('sundayclasses.edit', compact('class'));
    }

    // 6. Memperbarui data kelas
    public function update(Request $request, $encryptedId): RedirectResponse
    {
        $id = decrypt($encryptedId);

        // Validasi input
        $request->validate([
            'name'              => 'required|string|max:255',
            'description'       => 'nullable|string',
            'status'            => 'required|in:Active,Inactive',
            'schedule_id'       => 'required|exists:schedules,id', // Validasi jadwal harus ada
        ]);

        // Temukan kelas berdasarkan ID
        $class = SundaySchoolClass::findOrFail($id);

        // Periksa apakah status diubah menjadi 'Inactive' dan kelas memiliki anggota
        if ($request->input('status') === 'Inactive' && $class->members()->exists()) {
            return redirect()->back()->with('error', 'Kelas tidak dapat diubah menjadi Inactive karena masih memiliki anggota.');
        }

        // Perbarui data kelas
        $class->update([
            'name'        => $request->input('name'),
            'description' => $request->input('description'),
            'status'      => $request->input('status'),
        ]);

        // Perbarui relasi jadwal
        $class->schedules()->sync([$request->input('schedule_id')]);

        return redirect()->route('sunday-classes.index')->with('success', 'Data Berhasil Diperbarui!');
    }


    // 7. Menghapus kelas
    public function destroy($encryptedId): RedirectResponse
    {
        $id = decrypt($encryptedId);

        // Temukan kelas berdasarkan ID
        $class = SundaySchoolClass::findOrFail($id);

        // Periksa apakah masih ada anggota yang terkait dengan kelas
        if ($class->members()->exists()) {
            return redirect()->back()->with('error', 'Kelas tidak dapat dinonaktifkan karena masih memiliki anggota.');
        }

        // Ubah status kelas menjadi 'Inactive'
        $class->update([
            'status' => 'Inactive',
        ]);

        return redirect()->route('sunday-classes.index')->with('success', 'Status kelas berhasil diubah menjadi Inactive!');
    }

    public function active($encryptedId): RedirectResponse
    {
        $id = decrypt($encryptedId);

        // Temukan kelas berdasarkan ID
        $class = SundaySchoolClass::findOrFail($id);

        // Ubah status kelas menjadi 'Active'
        $class->update([
            'status' => 'Active',
        ]);

        return redirect()->route('sunday-classes.index')->with('success', 'Status kelas berhasil diubah menjadi Active!');
    }

    // 8. untuk menampilkan list anak yang terdaftar pada kelas
    public function viewClassStudents($encryptedId)
    {
        // Dekripsi classId
        $classId = decrypt($encryptedId);

        // Dapatkan kelas berdasarkan ID
        $class = SundaySchoolClass::findOrFail($classId);

        // Ambil parameter pencarian jika ada
        $search = request('search');

        // Ambil semua murid yang terdaftar di kelas ini melalui relasi many-to-many
        $studentsQuery = $class->members();

        // Jika ada parameter pencarian, filter berdasarkan nama murid
        if ($search) {
            $studentsQuery->where(function ($q) use ($search) {
                $q->where('firstname', 'LIKE', "%{$search}%")
                    ->orWhere('lastname', 'LIKE', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('email', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Urutkan murid berdasarkan nama dan paginasi
        $students = $studentsQuery->paginate(10);

        // Kembali ke view dengan data kelas dan murid
        return view('sundayclasses.class-students', [
            'class' => $class,
            'students' => $students,
            'encryptedClassId' => $encryptedId, // Kirimkan ID ter-enkripsi ke view
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