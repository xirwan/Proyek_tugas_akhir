@php
    use Illuminate\Support\Facades\Auth;
    use Carbon\Carbon;
    use App\Models\Activity;
    use App\Models\Member;
    use App\Models\MemberScheduleMonthly; // Tambah import model penjadwalan

    $user = Auth::user();
    // Cek Role Menggunakan Spatie Role
    $isSuperAdmin = $user->hasRole('SuperAdmin');
    $isAdmin = $user->hasRole('Admin');

    // Tentukan salam
    $hour = Carbon::now()->format('H');
    if ($hour < 12) {
        $greeting = "Selamat Pagi";
    } elseif ($hour < 15) {
        $greeting = "Selamat Siang";
    } elseif ($hour < 18) {
        $greeting = "Selamat Sore";
    } else {
        $greeting = "Selamat Malam";
    }

    // Jika SuperAdmin
    if ($isSuperAdmin) {
        $membersCount = Member::count();
        $activitiesCount = Activity::count(); // Semua kegiatan
        
        // Hitung jumlah penjadwalan (contoh: semua entry)
        $schedulesCount = MemberScheduleMonthly::count();
    }

    // Jika Admin
    if ($isAdmin) {
        $firstname = $user->member->firstname ?? 'Nama Depan';
        $lastname = $user->member->lastname ?? 'Nama Belakang';
        // Menghitung semua anak (member yang punya parents)
        $childrenCount = Member::has('parents')->count();
        // Menghitung kegiatan Approved dan Rejected
        $activitiesCount = Activity::whereIn('status', ['Approved', 'Rejected'])->count();
    }
@endphp

<x-app-layout>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="text-black mb-4">
        @if($isSuperAdmin)
            {{-- SuperAdmin: Tidak menampilkan nama depan belakang --}}
            <h3>{{ $greeting }}!</h3>
        @elseif($isAdmin)
            {{-- Admin: Tampilkan nama depan belakang --}}
            <h3>{{ $greeting }}, <span class="text-primary">{{ $firstname }} {{ $lastname }}!</span></h3>
        @else
            <h3>{{ $greeting }}!</h3>
        @endif
    </div>

    @if($isSuperAdmin)
        {{-- Dashboard untuk SuperAdmin --}}
        <div class="row g-3">
            <div class="col-md-6 mt-3">
                <section class="card card-featured-left card-featured-quaternary h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-quaternary">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title mb-2">Jumlah Anggota</h4>
                                    <div class="info">
                                        <strong class="amount badge bg-info text-dark px-3 py-2 rounded-pill">
                                            {{ $membersCount }}
                                        </strong>
                                    </div>
                                </div>
                                <div class="summary-footer mt-2">
                                    <a class="text-uppercase small fw-bold btn btn-link p-0" href="{{ route ('member.index') }}">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>                              
                    </div>
                </section>
            </div>
            <div class="col-md-6 mt-3">
                <section class="card card-featured-left card-featured-quaternary h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-quaternary">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title mb-2">Jumlah Kegiatan</h4>
                                    <div class="info">
                                        <strong class="amount badge bg-info text-dark px-3 py-2 rounded-pill">
                                            {{ $activitiesCount }}
                                        </strong>
                                    </div>
                                </div>
                                <div class="summary-footer mt-2">
                                    <a class="text-uppercase small fw-bold btn btn-link p-0" href="{{ route ('activities.index') }}">
                                        Lihat Kegiatan
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
		<div class="row">
			<div class="col-md-12">
                <section class="card card-featured-left card-featured-quaternary h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-quaternary">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title mb-2">Penjadwalan</h4>
                                    <div class="info">
                                        <strong class="amount badge bg-info text-dark px-3 py-2 rounded-pill">
                                            {{ $schedulesCount }}
                                        </strong>
                                    </div>
                                </div>
                                <div class="summary-footer mt-2">
                                    <a class="text-uppercase small fw-bold btn btn-link p-0" href="{{ route ('scheduling.index') }}">
                                        Lihat Penjadwalan
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
		</div>
    @elseif($isAdmin)
        {{-- Dashboard untuk Admin --}}
        <div class="row">
            <div class="col-md-6 mt-3">
                <section class="card card-featured-left card-featured-primary h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-primary">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title mb-2">Kode QR Anak</h4>
                                    <div class="info">
                                        <strong class="amount badge bg-info text-dark px-3 py-2 rounded-pill">
                                            {{ $childrenCount }}
                                        </strong>
                                    </div>
                                </div>
                                <div class="summary-footer mt-2">
                                    <a class="text-uppercase small fw-bold btn btn-link p-0" href="{{ route ('qr-code.children.list') }}">
                                        Lihat
                                    </a>
                                </div>
                            </div>                              
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-6 mt-3">
                <section class="card card-featured-left card-featured-primary h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-primary">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title mb-2">List Pengajuan Kegiatan</h4>
                                    <div class="info">
                                        <strong class="amount badge bg-info text-dark px-3 py-2 rounded-pill">
                                            {{ $activitiesCount }}
                                        </strong>
                                    </div>
                                </div>
                                <div class="summary-footer mt-2">
                                    <a class="text-uppercase small fw-bold btn btn-link p-0" href="{{ route('activities.index') }}">
                                        Lihat Kegiatan
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div class="row">
			<div class="col-md-6 mt-3">
                <section class="card card-featured-left card-featured-quaternary h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-quaternary">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title mb-2">Jadwal Mengajar</h4>
                                </div>
                                <div class="summary-footer mt-2">
                                    <a class="text-uppercase small fw-bold btn btn-link p-0" href="{{ route ('myschedule.index') }}">
                                        Lihat Jadwal
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-6 mt-3">
                <section class="card card-featured-left card-featured-quaternary h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-quaternary">
                                    <i class="fas fa-qrcode"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title mb-2">Scan Absensi</h4>
                                </div>
                                <div class="summary-footer mt-2">
                                    <a class="text-uppercase small fw-bold btn btn-link p-0" href="{{ route ('attendance.classListAdmin') }}">
                                        Lihat Fitur Scan
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    @else
        <p>Anda tidak memiliki hak akses untuk melihat dashboard ini.</p>
    @endif
</x-app-layout>