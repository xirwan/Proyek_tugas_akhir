<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Member;
use App\Models\Activity;
use App\Models\User;
use App\Models\MemberActivityRegistration;
use App\Models\ActivityPayment;
use App\Models\SelfActivityRegistration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Carbon\Carbon;
// use Midtrans\Config;
// use Midtrans\Snap;

class ActivityController extends Controller
{
    //
    //midtrans mulai
    // public function callback(Request $request)
    // {
    //     $serverKey = config('midtrans.server_key');
    //     $hashedKey = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

    //     if ($hashedKey !== $request->signature_key) {
    //         return response()->json(['message' => 'Invalid signature key'], 403);
    //     }

    //     $transactionStatus = $request->transaction_status;
    //     $orderId = $request->order_id;
    //     $order = ActivityPayment::where('midtrans_order_id', $orderId)->first();

    //     if (!$order) {
    //         return response()->json(['message' => 'Order not found'], 404);
    //     }

    //     switch ($transactionStatus) {
    //         case 'capture':
    //             if ($request->payment_type == 'credit_card') {
    //                 if ($request->fraud_status == 'challenge') {
    //                     $order->update(['midtrans_transaction_status' => 'pending']);
    //                 } else {
    //                     $order->update(['midtrans_transaction_status' => 'success']);
    //                 }
    //             }
    //             break;
    //         case 'settlement':
    //             // Dapatkan informasi kegiatan dan daftar anak dari transaksi
    //             $order->update(['midtrans_transaction_status' => 'settlement']);
    //             // $this->registerChildrenAfterPayment($order);
    //             break;
    //         case 'pending':
    //             $order->update(['midtrans_transaction_status' => 'pending']);
    //             break;
    //         case 'deny':
    //             $order->update(['midtrans_transaction_status' => 'failed']);
    //             break;
    //         case 'expire':
    //             $order->update(['midtrans_transaction_status' => 'expired']);
    //             break;
    //         case 'cancel':
    //             $order->update(['midtrans_transaction_status' => 'canceled']);
    //             break;
    //         default:
    //             $order->update(['midtrans_transaction_status' => 'unknown']);
    //             break;
    //     }

    //     return response()->json(['message' => 'Callback received successfully']);
    // }
    public function registerFormfree($activityId)
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

        // Cari pembayaran terkait kegiatan ini
        // $payment = ActivityPayment::where('activity_id', $activityId)
        //     ->where('parent_id', Auth::user()->member->id)
        //     ->where('midtrans_transaction_status', 'pending')
        //     ->first();

        // Kirim data ke view
        return view('activities.childrenregisterfree', compact('activity', 'allChildren', 'registeredChildrenIds', 'unregisteredChildren'));
    }
    public function registerSelfFormFree($activityId)
    {
        $activity = Activity::findOrFail($activityId);

        // Periksa apakah pengguna sudah terdaftar
        $isAlreadyRegistered = SelfActivityRegistration::where('activity_id', $activityId)
            ->where('member_id', Auth::user()->member->id)
            ->exists();

        if ($isAlreadyRegistered) {
            return redirect()->back()->withErrors('Anda sudah terdaftar di kegiatan ini.');
        }

        return view('activities.selfregisterfree', compact('activity'));
    }
    // public function registerForm($activityId)
    // {
    //     $activity = Activity::findOrFail($activityId);

    //     // Ambil semua anak milik orang tua
    //     $allChildren = Auth::user()->member->children;

    //     // Ambil ID anak yang sudah terdaftar di kegiatan ini
    //     $registeredChildrenIds = MemberActivityRegistration::where('activity_id', $activityId)
    //         ->where('registered_by', Auth::user()->member->id)
    //         ->pluck('child_id')
    //         ->toArray();

    //     // Filter anak yang belum terdaftar
    //     $unregisteredChildren = $allChildren->whereNotIn('id', $registeredChildrenIds);

    //     // Cari pembayaran terkait kegiatan ini
    //     $payment = ActivityPayment::where('activity_id', $activityId)
    //         ->where('parent_id', Auth::user()->member->id)
    //         ->where('midtrans_transaction_status', 'pending') // Transaksi dengan status pending
    //         ->first();

    //     // Kirim data ke view
    //     return view('activities.childrenregister', compact('activity', 'allChildren', 'registeredChildrenIds', 'unregisteredChildren', 'payment'));
    // }
    public function indexParent(Request $request)
    {
        // Ambil semua kegiatan yang sudah disetujui
        $activities = Activity::where('status', 'approved')
        ->whereDate('start_date', '>=', now()->toDateString()); // Menambahkan kondisi untuk memfilter kegiatan yang belum lewat

        $search = $request->query('search');
        if ($search) {
            $activities->where('title', 'LIKE', "%{$search}%");
        }

        // Filter berdasarkan jenis kegiatan
        if ($request->has('is_paid') && in_array($request->is_paid, ['0', '1'], true)) {
            $activities->where('is_paid', $request->is_paid);
        }

        // Ambil anak yang terhubung dengan pengguna saat ini
        $children = Auth::user()->member->children;

        // Ambil semua registrasi anak untuk kegiatan
        $registeredChildren = MemberActivityRegistration::whereIn('child_id', $children->pluck('id'))->get();

        // Filter berdasarkan status pendaftaran
        if ($request->has('is_registered') && in_array($request->is_registered, ['0', '1'], true)) {
            $registeredActivityIds = $registeredChildren->pluck('activity_id')->unique();
            if ($request->is_registered == '1') {
                // Sudah didaftarkan
                $activities->whereIn('id', $registeredActivityIds);
            } elseif ($request->is_registered == '0') {
                // Belum didaftarkan
                $activities->whereNotIn('id', $registeredActivityIds);
            }
        }

        // Paginate hasil query
        $activities = $activities->orderBy('start_date', 'asc')->paginate(10);

        // Periksa apakah tombol daftar harus muncul
        foreach ($activities as $activity) {
            // Anak-anak yang belum terdaftar untuk kegiatan ini
            $unregisteredChildren = $children->pluck('id')->diff(
                MemberActivityRegistration::where('activity_id', $activity->id)
                    ->pluck('child_id')
            );
        
            // Periksa apakah ada anak yang belum terdaftar
            $hasUnregisteredChildren = $unregisteredChildren->isNotEmpty();
        
            // Periksa apakah masih dalam rentang waktu pendaftaran
            $isWithinRegistrationPeriod = now()->between($activity->registration_open_date, $activity->registration_close_date);
        
            // Tentukan apakah tombol daftar muncul
            $activity->showRegisterButton = $hasUnregisteredChildren && $isWithinRegistrationPeriod;
        }        

        return view('activities.parentindex', compact('activities', 'children', 'search', 'registeredChildren'));
    }
    public function indexMember(Request $request)
    {
        // Ambil semua kegiatan yang sudah disetujui
        $activities = Activity::where('status', 'approved');

        // Filter berdasarkan jenis kegiatan (berbayar/tidak)
        if ($request->has('is_paid') && in_array($request->is_paid, ['0', '1'], true)) {
            $activities->where('is_paid', $request->is_paid);
        }

        // Ambil semua registrasi member untuk kegiatan
        $registeredActivities = SelfActivityRegistration::where('member_id', Auth::user()->member->id)->pluck('activity_id');

        // Filter berdasarkan status pendaftaran
        if ($request->has('is_registered') && in_array($request->is_registered, ['0', '1'], true)) {
            if ($request->is_registered == '1') {
                // Sudah didaftarkan
                $activities->whereIn('id', $registeredActivities);
            } elseif ($request->is_registered == '0') {
                // Belum didaftarkan
                $activities->whereNotIn('id', $registeredActivities);
            }
        }

        // Paginate hasil query
        $activities = $activities->orderBy('start_date', 'asc')->paginate(10);

        // Periksa apakah tombol daftar harus muncul
        foreach ($activities as $activity) {
            // Periksa apakah member sudah terdaftar
            $isRegistered = $registeredActivities->contains($activity->id);

            // Periksa apakah masih dalam rentang waktu pendaftaran
            $isWithinRegistrationPeriod = now()->between($activity->registration_open_date, $activity->registration_close_date);

            // Tentukan apakah tombol daftar muncul
            $activity->showRegisterButton = !$isRegistered && $isWithinRegistrationPeriod;
        }

        return view('activities.memberindex', compact('activities'));
    }
    public function registerfree(Request $request, $activityId)
    {
        
        $activity = Activity::findOrFail($activityId);

        // Validasi input
        $request->validate([
            'child_ids' => 'required|array|min:1',
            'child_ids.*' => 'exists:members,id',
        ]);

        // Ambil ID orang tua yang sedang login
        $parentId = Auth::user()->member->id;

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
    public function registerSelfFree(Request $request, $activityId)
    {
        $activity = Activity::findOrFail($activityId);

        // Validasi apakah member sudah terdaftar
        $isAlreadyRegistered = SelfActivityRegistration::where('activity_id', $activityId)
            ->where('member_id', Auth::user()->member->id)
            ->exists();

        if ($isAlreadyRegistered) {
            return redirect()->back()->withErrors('Anda sudah terdaftar di kegiatan ini.');
        }

        // Periksa apakah kegiatan memiliki batas maksimal peserta
        $isFull = $activity->max_participants && $activity->registrations->count() >= $activity->max_participants;

        if ($isFull) {
            return redirect()->back()->withErrors('Kegiatan ini sudah penuh.');
        }

        // Daftarkan member ke kegiatan
        SelfActivityRegistration::create([
            'activity_id' => $activityId,
            'member_id' => Auth::user()->member->id,
        ]);

        return redirect()->route('activities.member.index')->with('success', 'Anda berhasil mendaftarkan diri ke kegiatan.');
    }
    // public function register(Request $request, $activityId)
    // {
    //     $activity = Activity::findOrFail($activityId);

    //     // Validasi input
    //     $request->validate([
    //         'child_ids' => 'required|array|min:1',
    //         'child_ids.*' => 'exists:members,id',
    //     ]); 
        

    //     $parentId = Auth::user()->member->id;

    //     // Hitung total biaya
    //     $totalChildren = count($request->child_ids);
    //     $totalAmount = $activity->price * $totalChildren;

    //     if ($activity->is_paid) {
    //         $orderId = 'activity-' . $activity->id . '-parent-' . $parentId . '-' . time();

    //         // Konfigurasi Midtrans
    //         Config::$serverKey = env('MIDTRANS_SERVER_KEY');
    //         Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
    //         Config::$isSanitized = true;
    //         Config::$is3ds = true;

    //         $params = [
    //             'transaction_details' => [
    //                 'order_id' => $orderId,
    //                 'gross_amount' => $totalAmount,
    //             ],
    //             'customer_details' => [
    //                 'first_name' => Auth::user()->name,
    //                 'email' => Auth::user()->email,
    //             ],
    //             'item_details' => [
    //                 [
    //                     'id' => $activity->id,
    //                     'price' => $activity->price,
    //                     'quantity' => $totalChildren,
    //                     'name' => $activity->title,
    //                 ],
    //             ],
    //         ];

    //         try {
    //             // Buat transaksi menggunakan Midtrans
    //             $transaction = Snap::createTransaction($params);

    //             // Simpan Snap Token dan Payment URL ke database
    //             ActivityPayment::create([
    //                 'parent_id' => $parentId,
    //                 'activity_id' => $activityId,
    //                 'total_children' => $totalChildren,
    //                 'total_amount' => $totalAmount,
    //                 'midtrans_order_id' => $orderId,
    //                 'payment_token' => $transaction->token,
    //                 'payment_url' => $transaction->redirect_url, // Simpan Payment URL
    //                 'midtrans_transaction_status' => 'pending',
    //                 'child_ids' => $request->child_ids, // Simpan ID anak
    //             ]);
    //             $childrenIds = $request->child_ids;

    //             // Ubah semua elemen ke integer (jika perlu)
    //             $childrenIds = array_map('intval', $childrenIds);

    //             // Ambil ID anak yang sudah terdaftar untuk aktivitas ini
    //             $existingChildrenIds = MemberActivityRegistration::where('activity_id', $activityId)
    //                 ->pluck('child_id')
    //                 ->toArray();

    //             // Bandingkan untuk mendapatkan ID anak yang baru (belum terdaftar)
    //             $newChildrenIds = array_diff($childrenIds, $existingChildrenIds);

    //             // Lakukan pendaftaran untuk setiap anak baru
    //             foreach ($newChildrenIds as $childId) {
    //                 MemberActivityRegistration::create([
    //                     'activity_id' => $activityId,
    //                     'child_id' => $childId,
    //                     'registered_by' => $parentId,
    //                 ]);
    //             }

    //             // Kirim Snap Token ke frontend
    //             return response()->json(['snap_token' => $transaction->token]);
    //         } catch (\Exception $e) {
    //             return response()->json(['error' => $e->getMessage()], 500);
    //         }
    //     }
    //     return response()->json(['message' => 'Pendaftaran berhasil!']);
    // }
    // public function showParent($id)
    // {
    //     $activity = Activity::where('id', $id)
    //         ->where('status', 'approved')
    //         ->with(['registrations' => function ($query) {
    //             $query->where('registered_by', Auth::user()->member->id);
    //         }])
    //         ->firstOrFail();

    //     $childrenRegistered = $activity->registrations->pluck('child_id')->toArray();
    //     $children = Auth::user()->member->children;


    //     return view('activities.showparent', compact('activity', 'children', 'childrenRegistered'));
    // }
    //midtrans selesai

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

        $search = $request->query('search');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%");
            });
        }

        // Urutkan dan paginasi
        $activities = $query->orderBy('created_at', 'desc')->paginate(10);

        // Jika Superadmin, tambahkan daftar admin
        $admins = [];
        if ($user->hasRole('SuperAdmin')) {
            $admins = Member::where('status', 'Active')->whereHas('user', function ($query) {
                $query->role('Admin'); // Hanya ambil anggota yang memiliki peran Admin
            })->get();
        }

        // Tentukan apakah pengguna adalah Superadmin
        $isSuperadmin = $user->hasRole('SuperAdmin');
        
        // Kirim data ke view
        return view('activities.index', compact('activities', 'isSuperadmin', 'admins', 'search'));
    }

    // public function indexParent(Request $request)
    // {
    //     // Ambil semua kegiatan yang sudah disetujui
    //     $activities = Activity::where('status', 'approved');

    //     // Filter berdasarkan jenis kegiatan
    //     if ($request->has('is_paid') && in_array($request->is_paid, ['0', '1'], true)) {
    //         $activities->where('is_paid', $request->is_paid);
    //     }

    //     // Ambil anak yang terhubung dengan pengguna saat ini
    //     $children = Auth::user()->member->children;

    //     // Ambil semua registrasi anak untuk kegiatan
    //     $registeredChildren = MemberActivityRegistration::whereIn('child_id', $children->pluck('id'))->get();

    //     // Filter berdasarkan status pendaftaran
    //     if ($request->has('is_registered') && in_array($request->is_registered, ['0', '1'], true)) {
    //         $registeredActivityIds = $registeredChildren->pluck('activity_id')->unique();
    //         if ($request->is_registered == '1') {
    //             // Sudah didaftarkan
    //             $activities->whereIn('id', $registeredActivityIds);
    //         } elseif ($request->is_registered == '0') {
    //             // Belum didaftarkan
    //             $activities->whereNotIn('id', $registeredActivityIds);
    //         }
    //     }

    //     // Paginate hasil query
    //     $activities = $activities->orderBy('start_date', 'asc')->paginate(10);

    //     // Periksa apakah tombol daftar harus muncul
    //     foreach ($activities as $activity) {
    //         $allChildrenRegistered = $children->pluck('id')->diff(
    //             MemberActivityRegistration::where('activity_id', $activity->id)
    //                 ->pluck('child_id')
    //         )->isEmpty();

    //         // Tombol daftar muncul hanya jika:
    //         // - Anak belum semuanya terdaftar
    //         // - Bukti pembayaran belum diunggah jika kegiatan berbayar
    //         // - Masih dalam rentang waktu pendaftaran
    //         $activity->showRegisterButton = !$allChildrenRegistered &&
    //             (!$activity->is_paid || !ActivityPayment::where('parent_id', Auth::user()->member->id)
    //                 ->where('activity_id', $activity->id)
    //                 ->exists()) &&
    //             now()->between($activity->registration_open_date, $activity->registration_close_date);
    //     }

    //     return view('activities.parentindex', compact('activities', 'children', 'registeredChildren'));
    // }

    public function indexAdmin(Request $request)
    {
        $query = Activity::where('status', 'approved')->with('registrations');
        $search = $request->query('search');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%");
            });
        }
        
        $activities = $query->paginate(10);

        return view('activities.adminindex', compact('activities', 'search'));
    }
    public function indexAdminMember(Request $request)
    {
        $activities = Activity::where('status', 'approved')->with('registrations')->paginate(10);

        return view('activities.adminmemberindex', compact('activities'));
    }
    public function viewParticipants($id)
    {
        $activity = Activity::with(['payments.parent'])->findOrFail($id);

        // Ambil halaman saat ini untuk peserta dan pembayaran
        $participantsPage = request('participantsPage', 1);
        $paymentsPage = request('paymentsPage', 1);

        // Daftar peserta kegiatan
        $participantsQuery = MemberActivityRegistration::where('activity_id', $id)
            ->with(['child', 'parent', 'payment' => function ($query) use ($id) {
                $query->where('activity_id', $id);
            }]);

        // Daftar pembayaran
        $paymentsQuery = ActivityPayment::where('activity_id', $id)->with('parent');

        // Pagination
        $participants = $this->paginateQuery($participantsQuery->get(), 10, $participantsPage, 'participantsPage');
        $payments = $this->paginateQuery($paymentsQuery->get(), 10, $paymentsPage, 'paymentsPage');

        return view('activities.adminparticipants', compact('activity', 'participants', 'payments'));
    }

    public function viewSelfParticipants($id)
    {
        $activity = Activity::findOrFail($id);

        // Ambil halaman saat ini untuk peserta
        $participantsPage = request('participantsPage', 1);

        // Daftar peserta yang mendaftarkan diri sendiri
        $participantsQuery = SelfActivityRegistration::where('activity_id', $id)
            ->with('member');

        // Pagination
        $participants = $this->paginateQuery($participantsQuery->get(), 10, $participantsPage, 'participantsPage');

        return view('activities.adminmemberparticipants', compact('activity', 'participants'));
    }

    private function paginateQuery(Collection $items, $perPage, $currentPage, $pageName = 'page')
    {
        $currentItems = $items->forPage($currentPage, $perPage);
        return new LengthAwarePaginator($currentItems, $items->count(), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ]);
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

        // Periksa apakah tanggal payment_deadline sudah lewat, tangani jika null
        $isDeadlinePassed = $activity->payment_deadline 
            ? now()->greaterThan($activity->payment_deadline) 
            : false;

        return view('activities.showparent', compact('activity', 'children', 'childrenRegistered', 'isDeadlinePassed'));
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

        // Upload file pembayaran
        $paymentProofPath = $request->file('payment_proof')->store('payments', 'public');

        if ($existingPayment) {
            // Update pembayaran yang ada (termasuk jika masih "Diproses")
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

    public function verifyPayment(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'parent_id' => 'required|integer|exists:members,id',
        ]);

        // Cari pembayaran berdasarkan activity_id dan parent_id
        $payment = ActivityPayment::where('activity_id', $id)
                    ->where('parent_id', $request->parent_id)
                    ->first();

        if (!$payment) {
            return redirect()->back()->with('error', 'Pembayaran tidak ditemukan.');
        }

        // Periksa apakah pembayaran sudah diverifikasi
        if ($payment->payment_status === 'Berhasil') {
            return redirect()->back()->with('success', 'Pembayaran sudah diverifikasi.');
        }

        // Update status pembayaran
        $payment->payment_status = 'Berhasil';
        $payment->verified_by = Auth::id(); // Asumsikan pengguna saat ini adalah admin
        $payment->save();

        return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    public function rejectPayment(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'parent_id' => 'required|integer|exists:members,id',
        ]);

        // Cari pembayaran berdasarkan activity_id dan parent_id
        $payment = ActivityPayment::where('activity_id', $id)
                    ->where('parent_id', $request->parent_id)
                    ->first();

        if (!$payment) {
            return redirect()->back()->with('error', 'Pembayaran tidak ditemukan.');
        }

        // Periksa apakah pembayaran sudah ditolak
        if ($payment->payment_status === 'Ditolak') {
            return redirect()->back()->with('success', 'Pembayaran sudah ditolak sebelumnya.');
        }

        // Update status pembayaran
        $payment->payment_status = 'Ditolak';
        $payment->verified_by = Auth::id(); // Asumsikan pengguna saat ini adalah admin
        $payment->save();

   
        return redirect()->back()->with('success', 'Pembayaran berhasil ditolak.');
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
            'account_number' => [
                'required_if:is_paid,true',
                'nullable',
                'numeric',
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
            'account_number.required_if' => 'Nomor rekening wajib diisi jika kegiatan berbayar.',
            'account_number.numeric' => 'Nomor rekening harus berupa angka.',
            'max_participants.required' => 'Jumlah maksimal peserta wajib diisi.',
            'max_participants.integer' => 'Jumlah maksimal peserta harus berupa bilangan bulat.',
            'max_participants.min' => 'Jumlah maksimal peserta harus lebih dari nol.',
        ]);

        // Upload file proposal
        $proposalPath = null;
        if ($request->hasFile('proposal_file')) {
            $proposalPath = $request->file('proposal_file')->store('proposals', 'public'); // Simpan di folder 'proposals'
        }
        // Upload file poster
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
            'account_number' => $request->account_number ?? null, // Tambahkan nomor rekening
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
        $activity = Activity::findOrFail($id);

        // Periksa status dan peran pengguna
        $userRole = Auth::user()->roles->first()->name; // Ambil peran pengguna
        $currentStatus = $activity->status;

        // Atur validasi dinamis
        $today = now()->format('Y-m-d'); // Tanggal hari ini
        $validationRules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_paid' => 'required|boolean',
            'start_date' => 'required|date|after_or_equal:today',
            'proposal_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'poster_file' => 'nullable|file|mimes:pdf,jpeg,png,jpg,gif|max:2048',
            'max_participants' => 'required|integer|min:1',
            'price' => [
                'required_if:is_paid,true',
                'nullable',
                'numeric',
                'min:0',
            ],
            'account_number' => [
                'required_if:is_paid,true',
                'nullable',
                'numeric',
            ],
            'payment_deadline' => [
                'required_if:is_paid,true',
                'nullable',
                'date',
                'before_or_equal:start_date',
            ],
        ];

        // Validasi tanggal pendaftaran dibuka
        if ($activity->registration_open_date < $today) {
            // Jika tanggal pendaftaran sudah berlalu, tidak perlu validasi terhadap hari ini
            $validationRules['registration_open_date'] = 'required|date|before_or_equal:start_date';
        } else {
            $validationRules['registration_open_date'] = 'required|date|after_or_equal:today|before_or_equal:start_date';
        }

        // Validasi tanggal pendaftaran ditutup
        if ($activity->registration_close_date < $today) {
            // Jika tanggal penutupan sudah berlalu, tidak perlu validasi terhadap hari ini
            $validationRules['registration_close_date'] = 'required|date|after_or_equal:registration_open_date|before_or_equal:start_date';
        } else {
            $validationRules['registration_close_date'] = 'required|date|after_or_equal:today|after_or_equal:registration_open_date|before_or_equal:start_date';
        }

        // Lakukan validasi
        $request->validate($validationRules);

        // Kelola file proposal baru jika diunggah
        $proposalPath = $activity->proposal_file; // Tetap gunakan file lama jika tidak ada file baru
        if ($request->hasFile('proposal_file')) {
            $proposalPath = $request->file('proposal_file')->store('proposals', 'public'); // Ganti dengan file baru
        }

        $posterPath = $activity->poster_file; // Tetap gunakan file lama jika tidak ada file baru
        if ($request->hasFile('poster_file')) {
            $posterPath = $request->file('poster_file')->store('posters', 'public'); // Ganti dengan file baru
        }

        // Ubah status untuk pengajuan ulang
        $newStatus = $currentStatus;
        if ($currentStatus === 'rejected' && $userRole === 'Admin') {
            $newStatus = 'pending_approval'; // Pengajuan ulang oleh Admin
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
            'proposal_file' => $proposalPath,
            'poster_file' => $posterPath,
            'max_participants' => $request->max_participants,
            'account_number' => $request->account_number,
            'status' => $newStatus, // Update status berdasarkan kondisi
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

    public function history(Request $request)
{
    // Ambil data user yang sedang login
    $user = Auth::user(); 
    
    // Cari member_id berdasarkan user_id
    $member = Member::where('user_id', $user->id)->first();
    
    if (!$member) {
        return redirect()->back()->withErrors(['error' => 'Anda belum terdaftar sebagai pembina.']);
    }

    // Ambil semua pendaftaran aktivitas yang sudah terlewat oleh waktu nyata tanpa duplikasi activity_id dan registered_by
    $registrations = MemberActivityRegistration::where('registered_by', $member->id)
        ->whereHas('activity', function ($query) {
            // Filter hanya aktivitas yang sudah lewat tanggalnya
            $query->where('start_date', '<', Carbon::now());
        })
        ->select('activity_id', 'registered_by')
        ->distinct()
        ->with(['activity', 'activity.creator', 'activity.approver']) // Sertakan relasi jika perlu
        ->paginate(10);

    // Kirim data ke view
    return view('activities.history', compact('registrations'));
}

    




}
