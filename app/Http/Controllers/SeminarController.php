<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Seminar;
use App\Models\SeminarRegistration;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class SeminarController extends Controller
{
    //
    public function index()
    {
        // Update status seminar jika event_date telah lewat
        Seminar::where('event_date', '<', now())
            ->where('status', 'open')
            ->update(['status' => 'completed']);

        // Ambil semua seminar dari database
        $seminars = Seminar::orderBy('event_date', 'desc')->paginate(10);

        // Tampilkan ke view khusus admin
        return view('seminars.index', compact('seminars'));
    }

    public function indexAttendance()
    {
        // Update status seminar jika event_date telah lewat
        Seminar::where('event_date', '<', now())
            ->where('status', 'open')
            ->update(['status' => 'completed']);

        // Ambil semua seminar dari database
        $seminars = Seminar::orderBy('event_date', 'desc')->paginate(10);

        // Tampilkan ke view khusus admin
        return view('seminars.attendanceseminars', compact('seminars'));
    }

    public function indexMember()
    {
        $seminars = Seminar::where('status', 'open')
            ->whereDate('registration_end', '>=', now())
            ->get();

        return view('seminars.memberindex', compact('seminars'));
    }

    public function create()
    {
        return view('seminars.add');
    }

    public function show($id)
    {
        $seminar = Seminar::findOrFail($id);
        return view('seminars.show', compact('seminar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_participants' => 'required|integer|min:1',
            'poster_file' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048', 
            'event_date' => 'required|date',
            'start'         => 'required|date_format:H:i',
            'registration_start' => 'required|date|before_or_equal:event_date|before_or_equal:registration_end',
            'registration_end' => 'required|date|before_or_equal:event_date|after_or_equal:registration_start',
        ],[
            'registration_start.before_or_equal' => 'Tanggal pendaftaran harus sebelum atau sama dengan tanggal acara atau tanggal pendaftaran berakhir.',
            'registration_end.before_or_equal' => 'Tanggal pendaftaran berakhir harus sebelum atau sama dengan tanggal acara.',
            'registration_end.after_or_equal' => 'Tanggal pendaftaran berakhir harus setelah atau sama dengan tanggal pendaftaran dibuka.',
        ]);

        $poster = $request->file('poster_file');

        if ($poster) {
            $posterName = time() . '_' . Str::uuid() . '.' . $poster->getClientOriginalExtension();
            $posterPath = $poster->storeAs('posters', $posterName, 'public');
        }

        Seminar::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => 'open',
            'max_participants' => $request->max_participants,
            'poster_file' => $posterPath,
            'event_date' => $request->event_date,
            'start' => $request->start,
            'registration_start' => $request->registration_start,
            'registration_end' => $request->registration_end,
        ]);

        return redirect()->route('seminars.index')->with('success', 'Seminar berhasil dibuat.');
    }

    public function update(Request $request, $id)
    {
        $seminar = Seminar::findOrFail($id);

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'start'         => 'required|date_format:H:i',
            'registration_start' => 'required|date|before_or_equal:registration_end',
            'registration_end' => 'required|date|after_or_equal:registration_start',
            'max_participants' => 'required|integer|min:1',
            'poster_file' => 'nullable|image|max:2048', // File poster opsional
        ]);

        // Menangani poster baru
        if ($request->hasFile('poster_file')) {
            // Hapus poster lama jika ada
            if ($seminar->poster && Storage::exists('public/' . $seminar->poster)) {
                Storage::delete('public/' . $seminar->poster);
            }

            // Simpan poster baru
            $posterPath = $request->file('poster_file')->store('posters', 'public');
            $seminar->poster_file = $posterPath;
        }

        // Update data lainnya
        $seminar->update([
            'name' => $request->name,
            'description' => $request->description,
            'event_date' => $request->event_date,
            'start' => $request->start,
            'registration_start' => $request->registration_start,
            'registration_end' => $request->registration_end,
            'max_participants' => $request->max_participants,
        ]);

        return redirect()->route('seminars.index')->with('success', 'Seminar berhasil diperbarui.');
    }

    public function register($id)
    {
        // Ambil data seminar
        $seminar = Seminar::findOrFail($id);

        // Validasi: Apakah pendaftaran masih dibuka?
        if (now()->greaterThan($seminar->registration_end)) {
            return redirect()->back()->with('error', 'Pendaftaran sudah ditutup.');
        }

        // Validasi: Apakah kuota peserta sudah penuh?
        $currentParticipants = SeminarRegistration::where('seminar_id', $id)->count();
        if ($currentParticipants >= $seminar->max_participants) {
            return redirect()->back()->with('error', 'Kuota peserta sudah penuh.');
        }

        // Validasi: Apakah user sudah mendaftar sebelumnya?
        $alreadyRegistered = SeminarRegistration::where('seminar_id', $id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($alreadyRegistered) {
            return redirect()->back()->with('info', 'Anda sudah mendaftar di seminar ini.');
        }

        // Daftarkan user ke seminar
        SeminarRegistration::create([
            'user_id' => Auth::id(),
            'seminar_id' => $id,
            'is_attended' => false, // Default kehadiran
        ]);

        return redirect()->back()->with('success', 'Anda berhasil mendaftar ke seminar ini.');
    }

    public function showAttendance($id)
    {
        $seminar = Seminar::with(['registrations.member'])->findOrFail($id);

        return view('seminars.attendancemembers', compact('seminar'));
    }

    public function attendanceSeminars($id, Request $request)
    {
        $seminar = Seminar::findOrFail($id);

        // Validasi input checkbox
        $request->validate([
            'attended_users' => 'array', // Input harus berupa array
            'attended_users.*' => 'exists:users,id', // Pastikan ID user valid
        ]); 

        // Ambil semua registrasi peserta seminar
        $registrations = SeminarRegistration::where('seminar_id', $seminar->id)->get();

        // Perbarui kehadiran hanya untuk peserta yang dicentang
        foreach ($registrations as $registration) {
            $registration->is_attended = in_array($registration->user_id, $request->attended_users ?? []);
            $registration->save();
        }

        return redirect()->back()->with('success', 'Absensi berhasil diperbarui.');
    }



}
