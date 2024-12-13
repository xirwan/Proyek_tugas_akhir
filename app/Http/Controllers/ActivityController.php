<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Member;
use App\Models\Activity;
use App\Models\User;
use App\Models\MemberActivityRegistration;
Use App\Models\ActivityPayment;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    //
    public function index(Request $request)
    {
        $user = User::find(Auth::user()->id); // Ambil user yang sedang login
        $member = $user->member; // Relasi ke tabel member (asumsi user terkait dengan tabel member)

        // Mulai query dasar
        $query = Activity::query();

        // Filter berdasarkan peran menggunakan Spatie
        if ($user->hasRole('Admin')) {
            $query->where('created_by', $member->id); // Admin hanya melihat aktivitas yang dibuat oleh mereka
        } elseif (!$user->hasRole('SuperAdmin')) {
            abort(403, 'Anda tidak memiliki akses untuk melihat kegiatan.');
        }

        // Filter opsional berdasarkan status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Urutkan dan paginasi
        $activities = $query->orderBy('created_at', 'desc')->paginate(10);

        // Jika Superadmin, tambahkan daftar admin
        $admins = [];
        if ($user->hasRole('SuperAdmin')) {
            $admins = Member::whereHas('user', function ($query) {
                $query->role('Admin'); // Hanya ambil anggota yang memiliki peran Admin
            })->get();
        }

        // Tentukan apakah pengguna adalah Superadmin
        $isSuperadmin = $user->hasRole('SuperAdmin');

        // Kirim data ke view
        return view('activities.index', compact('activities', 'isSuperadmin', 'admins'));
    }

    public function indexParent(Request $request)
    {
        $activities = Activity::where('status', 'approved');

        // Filter berdasarkan jenis kegiatan
        if ($request->has('is_paid') && in_array($request->is_paid, ['0', '1'], true)) {
            $activities->where('is_paid', $request->is_paid);
        }

        // Paginate dan urutkan
        $activities = $activities->orderBy('start_date', 'asc')->paginate(10);

        return view('activities.parentindex', compact('activities'));
    }

    public function registerForm($activityId)
    {
        $activity = Activity::findOrFail($activityId);

        // Ambil semua anak milik orang tua
        $allChildren = Auth::user()->member->children;

        // Ambil ID anak yang sudah terdaftar di kegiatan ini
        $registeredChildrenIds = MemberActivityRegistration::where('activity_id', $activityId)
            ->where('registered_by', Auth::user()->member->id)
            ->pluck('child_id')
            ->toArray();

        // Filter anak yang belum terdaftar
        $unregisteredChildren = $allChildren->whereNotIn('id', $registeredChildrenIds);

        return view('activities.childrenregister', compact('activity', 'allChildren', 'registeredChildrenIds', 'unregisteredChildren'));
    }


    public function register(Request $request, $activityId)
    {
        $activity = Activity::findOrFail($activityId);

        // Validasi input
        $request->validate([
            'child_ids' => 'required|array|min:1',
            'child_ids.*' => 'exists:members,id',
        ]);

        // Ambil ID orang tua yang sedang login
        $parentId = Auth::user()->member->id;

        // Periksa apakah ada pembayaran untuk kegiatan ini
        $payment = ActivityPayment::where('activity_id', $activityId)
            ->where('parent_id', $parentId)
            ->first();

        if ($activity->is_paid && $payment && $payment->payment_status !== 'rejected') {
            // Jika kegiatan berbayar dan sudah ada bukti pembayaran (pending atau verified), tidak bisa menambahkan anak
            return redirect()->route('activities.parent.index')
                ->withErrors('Anda sudah mengunggah bukti pembayaran untuk kegiatan ini. Tidak dapat menambahkan anak baru.');
        }

        // Ambil ID anak yang sudah terdaftar untuk kegiatan ini
        $registeredChildrenIds = MemberActivityRegistration::where('activity_id', $activityId)
            ->where('registered_by', $parentId)
            ->pluck('child_id')
            ->toArray();

        // Filter anak baru dari input
        $newChildrenIds = array_diff($request->child_ids, $registeredChildrenIds);

        if (empty($newChildrenIds)) {
            return redirect()->back()->withErrors('Semua anak yang dipilih sudah terdaftar.');
        }

        // Masukkan anak baru ke tabel pendaftaran
        foreach ($newChildrenIds as $childId) {
            MemberActivityRegistration::create([
                'activity_id' => $activityId,
                'child_id' => $childId,
                'registered_by' => $parentId,
            ]);
        }


        // Jika kegiatan tidak berbayar, kembali ke daftar kegiatan
        return redirect()->route('activities.parent.index')->with('success', 'Anak berhasil didaftarkan ke kegiatan.');
    }

    public function showParent($id)
    {
        $activity = Activity::where('id', $id)
            ->where('status', 'approved')
            ->with(['registrations' => function ($query) {
                $query->where('registered_by', Auth::user()->member->id);
            }])
            ->firstOrFail();

        $childrenRegistered = $activity->registrations->pluck('child_id')->toArray();
        $children = Auth::user()->member->children;

        return view('activities.showparent', compact('activity', 'children', 'childrenRegistered'));
    }

    public function uploadPayment(Request $request, $activityId)
    {
        $request->validate([
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'payment_proof.required' => 'Bukti pembayaran harus diunggah.',
            'payment_proof.mimes' => 'Format file harus JPG, JPEG, PNG, atau PDF.',
            'payment_proof.max' => 'Ukuran file maksimal adalah 2MB.',
        ]);

        $activity = Activity::findOrFail($activityId);

        // Validasi apakah user sudah memiliki pembayaran untuk aktivitas ini
        $existingPayment = ActivityPayment::where('parent_id', Auth::user()->member->id)
            ->where('activity_id', $activityId)
            ->first();

        if ($existingPayment && $existingPayment->payment_status !== 'Ditolak') {
            return redirect()->back()->withErrors('Anda sudah mengunggah bukti pembayaran untuk kegiatan ini.');
        }

        // Upload file pembayaran
        $paymentProofPath = $request->file('payment_proof')->store('payments', 'public');

        if ($existingPayment) {
            // Update pembayaran yang ditolak
            $existingPayment->update([
                'payment_proof' => $paymentProofPath,
                'payment_status' => 'Diproses',
            ]);
        } else {
            // Buat data pembayaran baru
            $totalChildren = $activity->registrations()
                ->where('registered_by', Auth::user()->member->id)
                ->count();
            $totalAmount = $activity->price * $totalChildren;

            ActivityPayment::create([
                'parent_id' => Auth::user()->member->id,
                'activity_id' => $activityId,
                'total_children' => $totalChildren,
                'total_amount' => $totalAmount,
                'payment_proof' => $paymentProofPath,
                'payment_status' => 'Diproses',
            ]);
        }

        return redirect()->route('activities.parent.show', $activityId)
            ->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi.');
    }


    public function create()
    {
        return view('activities.add'); // Mengarahkan ke view untuk form tambah aktivitas
    }

    public function storeActivity(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_paid' => 'required|boolean',
            'start_date' => 'required|date|after_or_equal:today',
            'registration_open_date' => 'required|date|after_or_equal:today|before_or_equal:start_date',
            'registration_close_date' => 'required|date|after_or_equal:today|after_or_equal:registration_open_date|before_or_equal:start_date',
            'proposal_file' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'poster_file' => 'required|file|mimes:pdf,jpeg,png,jpg,gif|max:2048', 
            'max_participants' => 'required|integer|min:1',   
            'price' => [
                'required_if:is_paid,true',
                'nullable',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->is_paid == false && $value) {
                        $fail('Harga tidak boleh diisi jika kegiatan tidak berbayar.');
                    }
                    if (fmod($value, 1) !== 0.0) {
                        $fail('Harga harus berupa angka bulat tanpa desimal.');
                    }
                },
            ],
            'payment_deadline' => [
                'required_if:is_paid,true', // Wajib diisi jika kegiatan berbayar
                'nullable',
                'date',
                'after_or_equal:today',
                'before_or_equal:start_date',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->is_paid) {
                        if ($value < $request->registration_open_date) {
                            $fail('Tanggal batas pembayaran tidak boleh kurang dari tanggal pendaftaran dibuka.');
                        }
                        if ($value > $request->registration_close_date) {
                            $fail('Tanggal batas pembayaran tidak boleh lebih dari tanggal pendaftaran ditutup.');
                        }
                    }
                },
            ],
        ], [
            'start_date.after_or_equal' => 'Tanggal mulai tidak boleh kurang dari hari ini.',
            'registration_open_date.after_or_equal' => 'Tanggal pembukaan pendaftaran tidak boleh kurang dari hari ini.',
            'registration_open_date.before_or_equal' => 'Tanggal pembukaan pendaftaran tidak boleh melebihi tanggal mulai kegiatan.',
            'registration_close_date.after_or_equal' => 'Tanggal penutupan pendaftaran tidak boleh kurang dari hari ini atau tanggal pembukaan pendaftaran.',
            'registration_close_date.before_or_equal' => 'Tanggal penutupan pendaftaran tidak boleh melebihi tanggal mulai kegiatan.',
            'payment_deadline.after_or_equal' => 'Batas waktu pembayaran tidak boleh kurang dari hari ini.',
            'payment_deadline.before_or_equal' => 'Batas waktu pembayaran tidak boleh melebihi tanggal mulai kegiatan.',
            'proposal_file.required' => 'Proposal kegiatan wajib diunggah.',
            'proposal_file.max' => 'Ukuran file proposal tidak boleh lebih dari 2 MB.',
            'poster_file.required' => 'Poster kegiatan wajib diunggah.',
            'poster_file.max' => 'Ukuran file poster tidak boleh lebih dari 2 MB.',
            'price.required_if' => 'Harga wajib diisi jika kegiatan berbayar.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh bernilai negatif.',
            'max_participants.required' => 'Jumlah maksimal peserta wajib diisi.',
            'max_participants.integer' => 'Jumlah maksimal peserta harus berupa bilangan bulat.',
            'max_participants.min' => 'Jumlah maksimal peserta harus lebih dari nol.',
        ]);
         // Upload file proposal
        $proposalPath = null;
        if ($request->hasFile('proposal_file')) {
            $proposalPath = $request->file('proposal_file')->store('proposals', 'public'); // Simpan di folder 'proposals'
        }
        //Upload file poster
        $posterPath = null;
        if ($request->hasFile('poster_file')) {
            $posterPath = $request->file('poster_file')->store('posters', 'public'); // Simpan di folder 'posters'
        }
        $admin = Member::where('user_id', Auth::id())->first();

        Activity::create([
            'created_by' => $admin->id, // ID admin yang membuat
            'title' => $request->title,
            'description' => $request->description,
            'is_paid' => $request->is_paid,
            'price' => $request->price ?? 0,
            'start_date' => $request->start_date,
            'registration_open_date' => $request->registration_open_date,
            'registration_close_date' => $request->registration_close_date,
            'payment_deadline' => $request->payment_deadline,
            'status' => 'pending_approval',
            'proposal_file' => $proposalPath, // Path file proposal
            'poster_file' => $posterPath, // Path file proposal
            'max_participants' => $request->max_participants,
        ]);

        return redirect()->route('activities.index')->with(['success' => 'Pengajuan Kegiatan Berhasil Disimpan!']);
    }

    public function show($id)
    {
        $activity = Activity::with('creator')->findOrFail($id); // Ambil data aktivitas beserta pembuatnya
        return view('activities.show', compact('activity'));
    }

    public function edit($id)
    {
        $activity = Activity::findOrFail($id); // Ambil data berdasarkan ID
        return view('activities.edit', compact('activity'));
    }

    public function update(Request $request, $id)
    {
        $activity = Activity::findOrFail($id); // Ambil data aktivitas berdasarkan ID

        // Validasi data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_paid' => 'required|boolean',
            'start_date' => 'required|date|after_or_equal:today',
            'registration_open_date' => 'required|date|after_or_equal:today|before_or_equal:start_date',
            'registration_close_date' => 'required|date|after_or_equal:today|after_or_equal:registration_open_date|before_or_equal:start_date',
            'proposal_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'poster_file' => 'nullable|file|mimes:pdf,jpeg,png,jpg,gif|max:2048', 
            'max_participants' => 'required|integer|min:1',   
            'price' => [
                'required_if:is_paid,true',
                'nullable',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->is_paid == false && $value) {
                        $fail('Harga tidak boleh diisi jika kegiatan tidak berbayar.');
                    }
                    if (fmod($value, 1) !== 0.0) {
                        $fail('Harga harus berupa angka bulat tanpa desimal.');
                    }
                },
            ],
            'payment_deadline' => [
                'required_if:is_paid,true', // Wajib diisi jika kegiatan berbayar
                'nullable',
                'date',
                'after_or_equal:today',
                'before_or_equal:start_date',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->is_paid) {
                        if ($value < $request->registration_open_date) {
                            $fail('Tanggal batas pembayaran tidak boleh kurang dari tanggal pendaftaran dibuka.');
                        }
                        if ($value > $request->registration_close_date) {
                            $fail('Tanggal batas pembayaran tidak boleh lebih dari tanggal pendaftaran ditutup.');
                        }
                    }
                },
            ],
        ], [
            'start_date.after_or_equal' => 'Tanggal mulai tidak boleh kurang dari hari ini.',
            'registration_open_date.after_or_equal' => 'Tanggal pembukaan pendaftaran tidak boleh kurang dari hari ini.',
            'registration_open_date.before_or_equal' => 'Tanggal pembukaan pendaftaran tidak boleh melebihi tanggal mulai kegiatan.',
            'registration_close_date.after_or_equal' => 'Tanggal penutupan pendaftaran tidak boleh kurang dari hari ini atau tanggal pembukaan pendaftaran.',
            'registration_close_date.before_or_equal' => 'Tanggal penutupan pendaftaran tidak boleh melebihi tanggal mulai kegiatan.',
            'payment_deadline.after_or_equal' => 'Batas waktu pembayaran tidak boleh kurang dari hari ini.',
            'payment_deadline.before_or_equal' => 'Batas waktu pembayaran tidak boleh melebihi tanggal mulai kegiatan.',
            'proposal_file.required' => 'Proposal kegiatan wajib diunggah.',
            'proposal_file.max' => 'Ukuran file proposal tidak boleh lebih dari 2 MB.',
            'poster_file.required' => 'Poster kegiatan wajib diunggah.',
            'poster_file.max' => 'Ukuran file poster tidak boleh lebih dari 2 MB.',
            'price.required_if' => 'Harga wajib diisi jika kegiatan berbayar.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh bernilai negatif.',
            'max_participants.required' => 'Jumlah maksimal peserta wajib diisi.',
            'max_participants.integer' => 'Jumlah maksimal peserta harus berupa bilangan bulat.',
            'max_participants.min' => 'Jumlah maksimal peserta harus lebih dari nol.',
        ]);

        // Kelola file proposal baru jika diunggah
        $proposalPath = $activity->proposal_file; // Tetap gunakan file lama jika tidak ada file baru

        if ($request->hasFile('proposal_file')) {
            $proposalPath = $request->file('proposal_file')->store('proposals', 'public'); // Ganti dengan file baru
        }

        $posterPath = $activity->poster_file; // Tetap gunakan file lama jika tidak ada file baru

        if ($request->hasFile('poster_file')) {
            $posterPath = $request->file('poster_file')->store('posters', 'public'); // Ganti dengan file baru
        }

        // Update data aktivitas
        $activity->update([
            'title' => $request->title,
            'description' => $request->description,
            'is_paid' => $request->is_paid,
            'price' => $request->price ?? 0,
            'start_date' => $request->start_date,
            'registration_open_date' => $request->registration_open_date,
            'registration_close_date' => $request->registration_close_date,
            'payment_deadline' => $request->payment_deadline,
            'proposal_file' => $proposalPath, // Simpan path file baru atau tetap gunakan file lama
            'poster_file' => $posterPath,
            'max_participants' => $request->max_participants,
        ]);

        return redirect()->route('activities.index')->with(['success' => 'Kegiatan berhasil diperbarui!']);
    }


    public function approveActivity($id)
    {
        $activity = Activity::findOrFail($id);

        if ($activity->status !== 'pending_approval') {
            return redirect()->back()->withErrors('Kegiatan tidak dapat disetujui.');
        }

        $activity->update([
            'status' => 'approved',
            'approved_by' => Auth::user()->id, // ID superadmin yang menyetujui
        ]);

        return redirect()->back()->with('success', 'Kegiatan Berhasil Disetujui.');
    }

    public function rejectActivity(Request $request, $id)
    {
        $activity = Activity::findOrFail($id);

        if ($activity->status !== 'pending_approval') {
            return redirect()->back()->withErrors('Kegiatan tidak dapat ditolak karena bukan dalam status "Pending Approval".');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:500', // Alasan penolakan wajib diisi
        ]);

        $activity->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason, // Simpan alasan penolakan
        ]);

        return redirect()->back()->with('success', 'Kegiatan berhasil ditolak.');
    }

}
