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
                        <a class="nav-link" href="{{url ('/')}}">
                            <i class="bx bx-home-alt" aria-hidden="true"></i>
                            <span>Home</span>
                        </a>                        
                    </li>
                    <x-side-link href="#" :active="request()->is('member/children') || request()->is('member/register-child')" class="nav-parent" :items="[
                        ['url' => route('member.childrenList'), 'label' => 'List Anak'],
                        ['url' => route('member.createChildForm'), 'label' => 'Daftar Anak'],
                    ]">
                        <i class="bx bx-calendar" aria-hidden="true"></i>
                        <span>Anak</span>
                    </x-side-link>
                    <x-side-link href="{{route ('memberbaptist.index')}}" :active="request()->is('member-baptist')">
                        <i class="bx bx-layout" aria-hidden="true"></i>
                        <span>Daftar Pembaptisan</span>
                    </x-side-link>
                    <x-side-link href="{{route ('memberbaptist.details')}}" :active="request()->is('member-baptist/class-details')">
                        <i class="bx bx-layout" aria-hidden="true"></i>
                        <span>Kelas Pembaptisan</span>
                    </x-side-link>
                    <x-side-link href="{{route ('attendance.parentView')}}" :active="request()->is('attendance/parent-view')">
                        <i class="bx bx-layout" aria-hidden="true"></i>
                        <span>Absensi Anak</span>
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
						<h2 style="border-bottom: none">
                            {{ Str::title(str_replace('-', ' ', last(request()->segments()))) }}
                        </h2>                                                
						<div class="right-wrapper text-right" style="padding-right: 20px">
							<ol class="breadcrumbs">
								<li>
									<a href="{{url ('/portal')}}">
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