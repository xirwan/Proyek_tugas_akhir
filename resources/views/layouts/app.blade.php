<!doctype html>
<html class="fixed">
	<head>
        <title>{{ config('app.name', 'Laravel') }}</title>
		<script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
        @include('admin.css')        
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
                    
                    <x-side-link href="{{url ('branch')}}" :active="request()->is('branch*')">
                        <i class="bx bx-building-house" aria-hidden="true"></i>
                        <span>Cabang</span>
                    </x-side-link>
                    
                    <x-side-link href="{{url ('role')}}" :active="request()->is('role')">
                        <i class="bx bx-user-plus" aria-hidden="true"></i>
                        <span>Role</span>
                    </x-side-link>

                    <x-side-link href="{{url ('position')}}" :active="request()->is('position')">
                        <i class="bx bx-user-plus" aria-hidden="true"></i>
                        <span>Posisi</span>
                    </x-side-link>
        
                    <x-side-link href="{{url ('member')}}" :active="request()->is('member*')">
                        <i class="bx bx-user" aria-hidden="true"></i>
                        <span>Anggota</span>
                    </x-side-link>
        
                    <x-side-link href="#" :active="request()->is('schedule*') || request()->is('type*') || request()->is('category*')" class="nav-parent" :items="[
                        ['url' => url('schedule'), 'label' => 'List Jadwal'],
                        ['url' => url('type'), 'label' => 'Tipe Jadwal'],
                        ['url' => url('category'), 'label' => 'Kategori Jadwal'],
                    ]">
                        <i class="bx bx-calendar" aria-hidden="true"></i>
                        <span>Jadwal</span>
                    </x-side-link>
        
                    <x-side-link href="{{url ('sunday-classes')}}" :active="request()->is('sunday-classes*')">
                        <i class="bx bx-layout" aria-hidden="true"></i>
                        <span>List Kelas Sekolah Minggu</span>
                    </x-side-link>
        
                    <x-side-link href="{{url ('qr-code/children')}}" :active="request()->is('qr-code/children')">
                        <i class="bx bx-layout" aria-hidden="true"></i>
                        <span>Generate QR Anak Sekolah Minggu</span>
                    </x-side-link>

                    <x-side-link href="#" :active="request()->is('baptist*')" class="nav-parent" :items="[
                        ['url' => url('baptist'), 'label' => 'List Jadwal Pembaptisan'],
                        ['url' => url('baptist-classes'), 'label' => 'List Kelas Pembaptisan'],
                    ]">
                        <i class="bx bx-calendar" aria-hidden="true"></i>
                        <span>Pembaptisan</span>
                    </x-side-link>

                    <x-side-link href="#" :active="request()->is('attendance*')" class="nav-parent" :items="[
                        ['url' => url('/attendance/class'), 'label' => 'Absensi Sekolah Minggu'],
                        ['url' => url('/attendance/history'), 'label' => 'Riwayat Absensi Sekolah Minggu'],
                    ]">
                        <i class="bx bx-calendar" aria-hidden="true"></i>
                        <span>Absensi</span>
                    </x-side-link>
        
                    <x-side-link href="{{url ('coba')}}" :active="request()->is('coba')">
                        <i class="bx bx-layout" aria-hidden="true"></i>
                        <span>Layouts</span>
                    </x-side-link>
                    
                </x-sidebar>

				<section role="main" class="content-body">
					<header class="page-header">
						<h2 style="border-bottom: none">{{ ucfirst(request()->segment(1)) }}</h2>
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