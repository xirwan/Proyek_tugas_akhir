<!doctype html>
<html class="fixed">
	<head>
        <title>{{ config('app.name', 'Laravel') }}</title>
		{{-- <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script> --}}
        @include('admin.css')        
        {{-- <style>
    
            #sidebar-left .nav-main ul li a {
                color: white !important;
            }
    
            #sidebar-left .nav-main ul li a:hover {
                background-color: #0056b3 !important; /* Hover dengan biru lebih gelap */
                color: white !important;
            }
        </style> --}}
	</head>
	<body>
        <section class="body">

			@include('admin.header')

			<div class="inner-wrapper">

                <x-sidebar>

                    <li>			
                        <a class="nav-link" href="{{url ('dashboard')}}">
                            <i class="bx bx-home-alt" aria-hidden="true"></i>
                            <span>Dashboard</span>
                        </a>                        
                    </li>

                    @if(auth()->user()->hasRole('Admin'))
                        <x-side-link href="{{url ('/my-schedule')}}" :active="request()->is('my-schedule*')">
                            <i class="bx bx-calendar" aria-hidden="true"></i>
                            <span>Jadwal</span>
                        </x-side-link>
                        <x-side-link1 href="#" :active="request()->is('sunday-school*')" icon="bx bx-home-smile" class="nav-parent" :items="[
                            ['url' => url('sunday-school/sunday-classes'), 'label' => 'List Kelas',],
                            ['url' => url('sunday-school/qr-code/children'), 'label' => 'List Anak',],
                            ['url' => url('#'), 'label' => 'Absensi', 'items' => [
                                    ['url' => url('sunday-school/attendance/class-admin'), 'label' => 'Scan',],
                                    ['url' => url('sunday-school/attendance/history'), 'label' => 'Riwayat Absensi Sekolah Minggu',],
                                    ['url' => url('sunday-school/reports/mentor'), 'label' => 'Laporan Sekolah Minggu',],
                                ],
                            ],
                        ]">
                            <span>Sekolah Minggu</span>
                        </x-side-link1>

                        <x-side-link href="#" :active="request()->is('activities*')" class="nav-parent" :items="[
                            ['url' => url('activities'), 'label' => 'List Pengajuan'],
                            ['url' => route('listactivities.index'), 'label' => 'List Kegiatan'],
                            ['url' => route('listactivitiesmember.index'), 'label' => 'List Kegiatan Remaja'],
                        ]">
                            <i class="bx bxs-calendar-event" aria-hidden="true"></i>
                            <span>Kegiatan</span>
                        </x-side-link>

                    @endif

                    @if(auth()->user()->hasRole('SuperAdmin'))
                        <x-side-link1 href="#" :active="request()->is('master-data*')" icon="bx bx-data" class="nav-parent" :items="[
                            ['url' => url('master-data/branch'), 'label' => 'Cabang',],
                            ['url' => url('master-data/position'), 'label' => 'Posisi',],
                            ['url' => url('#'), 'label' => 'Keanggotaan', 'items' => [
                                    ['url' => url('master-data/member'), 'label' => 'Anggota',],
                                    ['url' => url('master-data/certifications'), 'label' => 'Verifikasi Keanggotaan',],
                                ],
                            ],
                            ['url' => url('#'), 'label' => 'Jadwal', 'items' => [
                                    ['url' => url('master-data/type'), 'label' => 'Tipe Jadwal',],
                                    ['url' => url('master-data/category'), 'label' => 'Kategori Jadwal',],
                                    ['url' => url('master-data/schedule'), 'label' => 'List Jadwal',],
                                    // ['url' => url('master-data/schedule-member'), 'label' => 'Generate kode QR Jadwal',],
                                ],
                            ],
                        ]">
                            <span>Master Data</span>
                        </x-side-link1>

                        <x-side-link href="{{ url ('scheduling')}}" :active="request()->is('scheduling*')">
                            <i class="bx bx-calendar" aria-hidden="true"></i>
                            <span>Penjadwalan</span>
                        </x-side-link>
                        <x-side-link1 href="#" :active="request()->is('sunday-school*')" icon="bx bx-home-smile" class="nav-parent" :items="[
                            ['url' => url('sunday-school/sunday-classes'), 'label' => 'List Kelas',],
                            ['url' => url('sunday-school/qr-code/children'), 'label' => 'List Anak',],
                            ['url' => url('#'), 'label' => 'Absensi', 'items' => [
                                    ['url' => url('sunday-school/attendance/class'), 'label' => 'Scan',],
                                    ['url' => url('sunday-school/attendance/history'), 'label' => 'Riwayat Absensi Sekolah Minggu',],
                                    ['url' => url('sunday-school/reports'), 'label' => 'Laporan Sekolah Minggu',],
                                ],
                            ],
                        ]">
                            <span>Sekolah Minggu</span>
                        </x-side-link1>

                        <x-side-link href="#" :active="request()->is('activities*') || request()->is('activity*')" class="nav-parent" :items="[
                            ['url' => url('activities'), 'label' => 'List Pengajuan'],
                            ['url' => route('listactivities.index'), 'label' => 'List Kegiatan'],
                            ['url' => route('listactivitiesmember.index'), 'label' => 'List Kegiatan Remaja'],
                        ]">
                            <i class="bx bxs-calendar-event" aria-hidden="true"></i>
                            <span>Kegiatan</span>
                        </x-side-link>

                    @endif
                    {{-- joel --}}

                    <x-side-link href="#" :active="request()->is('seminars*') || request()->is('attendance-seminars*') || request()->is('generate-seminar*')" class="nav-parent" :items="[
                        ['url' => url('seminars'), 'label' => 'List Seminar'],
                        ['url' => url('attendance-seminars'), 'label' => 'List Peserta Seminar'],
                        ['url' => url('generate-seminar'), 'label' => 'List Setifikat Seminar'],
                    ]">
                        <i class="bx bxs-calendar-event" aria-hidden="true"></i>
                        <span>Seminar</span>
                    </x-side-link>
                    
                    <x-side-link href="#" :active="request()->is('baptist*') || request()->is('generate-pembaptisan*')" class="nav-parent" :items="[
                        ['url' => url('baptist'), 'label' => 'List Jadwal Pembaptisan'],
                        ['url' => url('generate-pembaptisan'), 'label' => 'List Setifikat Pembaptisan'],
                        ]">
                        <i class="bx bx-calendar" aria-hidden="true"></i>
                        <span>Pembaptisan</span>
                    </x-side-link>

                    <x-side-link href="{{url ('/member-checklist')}}" :active="request()->is('member-checklist*') || request()->is('attendance-members*')">
                        <i class="bx bxs-check-square" aria-hidden="true"></i>
                        <span>Absensi Remaja</span>
                    </x-side-link>

                </x-sidebar>

				<section role="main" class="content-body">
					<header class="page-header">
						<h2 style="border-bottom: none">GBI Sungai Yordan</h2>
                        {{-- <h2 style="border-bottom: none">
                            {{ Str::title(str_replace('-', ' ', count(request()->segments()) > 1 ? request()->segment(2) : request()->segment(1))) }}
                        </h2> --}}
						<div class="right-wrapper text-right" style="padding-right: 20px">
							<ol class="breadcrumbs">
								<li>
									<a href="{{url ('dashboard')}}">
										<i class="bx bx-home-alt"></i>
									</a>
								</li>
							</ol>
						</div>
					</header>
                    {{ $slot }}
				</section>
			</div>
		</section>
		@include('admin.script')
	</body>
</html>