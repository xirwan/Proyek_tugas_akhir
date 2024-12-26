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
                            <a class="nav-link" href="{{url ('/portal')}}">
                                <i class="bx bx-home-alt" aria-hidden="true"></i>
                                <span>Home</span>
                            </a>                        
                        </li>
                        <x-side-link href="#" :active="request()->is('member/children*') || request()->is('member/register-child*') || request()->is('attendance/parent-view*')" class="nav-parent" :items="[
                            ['url' => route('member.childrenList'), 'label' => 'List Anak'],
                            ['url' => route('member.createChildForm'), 'label' => 'Daftar Anak'],
                            ['url' => route('attendance.parentView'), 'label' => 'Absensi Anak'],
                        ]">
                            <i class="bx bx-user" aria-hidden="true"></i>
                            <span>Anak</span>
                        </x-side-link>
                        <x-side-link href="{{route ('activities.parent.index')}}" :active="request()->is('childrens-activities*')">
                            <i class="bx bxs-calendar-event" aria-hidden="true"></i>
                            <span>Kegiatan</span>
                        </x-side-link>
                        {{-- joel --}}
                        {{-- <x-side-link href="{{route ('seminars.indexmember')}}" :active="request()->is('member-seminar*')">
                            <i class="bx bx-calendar" aria-hidden="true"></i>
                            <span>Seminar</span>
                        </x-side-link> --}}
                        <x-side-link href="#" :active="request()->is('member-seminar*')" class="nav-parent" :items="[
                            ['url' => route('seminars.indexmember'), 'label' => 'Daftar Seminar'],
                            ['url' => route('seminars.certificate'), 'label' => 'Sertifikat Seminar'],
                        ]">
                            <i class="bx bx-calendar" aria-hidden="true"></i>
                            <span>Seminar</span>
                        </x-side-link>
                        <x-side-link href="#" :active="request()->is('member-baptist*')" class="nav-parent" :items="[
                            ['url' => route('memberbaptist.index'), 'label' => 'Daftar Pembaptisan'],
                            ['url' => route('memberbaptist.details'), 'label' => 'Kelas Pembaptisan'],
                            ['url' => route('baptist.certificate'), 'label' => 'Sertifikat Pembaptisan'],
                        ]">
                            <i class="bx bx-calendar" aria-hidden="true"></i>
                            <span>Pembaptisan</span>
                        </x-side-link>
                        <x-side-link href="{{route ('activities.member.index')}}" :active="request()->is('activities-member*')">
                            <i class="bx bxs-calendar-event" aria-hidden="true"></i>
                            <span>Kegiatan 'Joel'</span>
                        </x-side-link>
                        <x-side-link href="#" :active="request()->is('member-scan*')" class="nav-parent" :items="[
                            ['url' => route('attendance.member.scan'), 'label' => 'Scan'],
                            ['url' => route('attendance.memberView'), 'label' => 'Riwayat'],
                        ]">
                            <i class="bx bxs-camera" aria-hidden="true"></i>
                            <span>Absensi</span>
                        </x-side-link>
                        <x-side-link href="{{url ('certifications/upload')}}" :active="request()->is('certifications/upload')">
                            <i class="bx bx-user-plus" aria-hidden="true"></i>
                            <span>Pengajuan Keanggotaan</span>
                        </x-side-link>
                    </x-sidebar>
                    <section role="main" class="content-body">
                        <header class="page-header">
                            <h2 style="border-bottom: none">GBI Sungai Yordan</h2>                                                
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