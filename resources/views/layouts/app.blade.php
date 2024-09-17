<!doctype html>
<html class="fixed">
	<head>
        <title>{{ config('app.name', 'Laravel') }}</title>
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
                    
                    <x-side-link href="{{url ('cabang')}}" :active="request()->is('cabang')">
                        <i class="bx bx-building-house" aria-hidden="true"></i>
                        <span>Cabang</span>
                    </x-side-link>
                    
                    <x-side-link href="{{url ('role')}}" :active="request()->is('role')">
                        <i class="bx bx-user-plus" aria-hidden="true"></i>
                        <span>Role</span>
                    </x-side-link>

                    {{-- <x-side-link href="{{url ('permission')}}" :active="request()->is('permission')">
                        <i class="bx bx-user-plus" aria-hidden="true"></i>
                        <span>Permission</span>
                    </x-side-link> --}}
        
                    <x-side-link href="{{url ('anggota')}}" :active="request()->is('anggota')">
                        <i class="bx bx-user" aria-hidden="true"></i>
                        <span>Anggota</span>
                    </x-side-link>
        
                    <x-side-link href="{{url ('jadwal')}}" :active="request()->is('jadwal')">
                        <i class="bx bx-calendar" aria-hidden="true"></i>
                        <span>Jadwal</span>
                    </x-side-link>
        
                    <x-side-link href="{{url ('coba')}}" :active="request()->is('coba')">
                        <i class="bx bx-layout" aria-hidden="true"></i>
                        <span>Layouts</span>
                    </x-side-link>
        
                    <x-side-link href="{{url ('coba')}}" :active="request()->is('coba')">
                        <i class="bx bx-layout" aria-hidden="true"></i>
                        <span>Layouts</span>
                    </x-side-link>
        
                    <x-side-link href="{{url ('coba')}}" :active="request()->is('coba')">
                        <i class="bx bx-layout" aria-hidden="true"></i>
                        <span>Layouts</span>
                    </x-side-link>
        
                    <x-side-link href="{{url ('coba')}}" :active="request()->is('coba')">
                        <i class="bx bx-layout" aria-hidden="true"></i>
                        <span>Layouts</span>
                    </x-side-link>
        
                    <x-side-link href="{{url ('coba')}}" :active="request()->is('coba')">
                        <i class="bx bx-layout" aria-hidden="true"></i>
                        <span>Layouts</span>
                    </x-side-link>
                    
                </x-sidebar>

				<section role="main" class="content-body">
					<header class="page-header">
						<h2 style="border-bottom: none">{{ ucfirst(request()->segment(1)) }}</h2>
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