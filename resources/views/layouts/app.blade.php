{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html> --}}

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
                        <i class="bx bx-layout" aria-hidden="true"></i>
                        <span>Cabang</span>
                    </x-side-link>
                    
                    <x-side-link href="{{url ('coba')}}" :active="request()->is('coba')">
                        <i class="bx bx-layout" aria-hidden="true"></i>
                        <span>Role</span>
                    </x-side-link>
        
                    <x-side-link href="{{url ('coba')}}" :active="request()->is('coba')">
                        <i class="bx bx-layout" aria-hidden="true"></i>
                        <span>Anggota</span>
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
        
                    <x-side-link href="{{url ('coba')}}" :active="request()->is('coba')">
                        <i class="bx bx-layout" aria-hidden="true"></i>
                        <span>Layouts</span>
                    </x-side-link>
                    
                </x-sidebar>

				<section role="main" class="content-body">
					<header class="page-header">
						<h2 style="border-bottom: none">{{ strtoupper(request()->path()) }}</h2>
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