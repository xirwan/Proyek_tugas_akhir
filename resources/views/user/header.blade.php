<header id="header" class="header header-nav-links header-nav-menu h-auto py-1" data-plugin-options="{'stickyEnabled': true, 'stickyEffect': 'shrink', 'stickyEnableOnBoxed': false, 'stickyEnableOnMobile': true, 'stickyStartAt': 70, 'stickyChangeLogo': false, 'stickyHeaderContainerHeight': 70}">
    <div class="header-body border-top-0 bg-dark box-shadow-none h-auto">
        <div class="header-container container h-100">
            <div class="header-row h-100">
                <div class="header-column">
                    <div class="header-row">
                        <div class="header-logo">
                            <a href="#" class="goto-top">
                                <img src="{{asset ('admintemp/img/logo.png')}}" alt="logo_GBI" width="50" class="rounded-circle">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="header-column justify-content-end">
                    <div class="header-row">
                        
                        <button class="btn header-btn-collapse-nav d-lg-none order-3 mt-0 ml-3 mr-0" data-toggle="collapse" data-target=".header-nav">
                            <i class="fas fa-bars"></i>
                        </button>
                        
                        <!-- start: header nav menu -->
                        <div class="header-nav header-nav-links header-nav-light-text header-nav-dropdowns-dark collapse">
                            <div class="header-nav-main header-nav-main-mobile-dark header-nav-main-effect-1 header-nav-main-sub-effect-1">
                                <nav>
                                    <ul class="nav nav-pills" id="mainNav">
                                        <li>
                                            <a class="nav-link" href="#" data-hash data-hash-offset="120">
                                                Home
                                            </a>    
                                        </li>

                                        {{-- <li>
                                            <a class="nav-link" href="#cabang" data-hash data-hash-offset="120">
                                                Cabang
                                            </a>    
                                        </li> --}}

                                        
                                        <li class="dropdown">
                                            <a class="nav-link dropdown-toggle" href="#">
                                                Jadwal Ibadah
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="nav-link" href="pages-signup.html">
                                                        Ibadah Umum
                                                    </a>
                                                </li>
                                                
                                                <li>
                                                    <a class="nav-link" href="pages-signup.html">
                                                        Ibadah Anak/remaja
                                                    </a>
                                                </li>
                                                
                                                
                                            </ul>
                                        </li>
                                        {{-- <li class="dropdown">
                                            <a class="nav-link dropdown-toggle" href="#">
                                                Layanan
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="nav-link" href="{{ route('pembaptisan') }}">
                                                        Pembaptisan
                                                    </a>
                                                </li>
                                                
                                                <li>
                                                    <a class="nav-link" href="pages-signup.html">
                                                        Pemuridan
                                                    </a>
                                                </li>
                                                
                                                <li>
                                                    <a class="nav-link" href="pages-signup.html">
                                                        Penyerahan Anak
                                                    </a>
                                                </li>
                                                
                                                <li>
                                                    <a class="nav-link" href="pages-signup.html">
                                                        Permohonan Doa
                                                    </a>
                                                </li>

                                                <li>
                                                    <a class="nav-link" href="pages-signup.html">
                                                        Pemberkatan Nikah
                                                    </a>
                                                </li>

                                                <li>
                                                    <a class="nav-link" href="pages-signup.html">
                                                        Pendaftaran Komunitas
                                                    </a>
                                                </li>

                                                <li>
                                                    <a class="nav-link" href="pages-signup.html">
                                                        Pendaftaran Sekolah Minggu
                                                    </a>
                                                </li>
                                                
                                            </ul>
                                        </li>--}}
                                        @if (Route::has('login'))
                                        @auth
                                        <li class="dropdown">
                                            <a class="nav-link dropdown-toggle" href="#">
                                                {{ Auth::user()->name }}
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="nav-link" href="{{ route('userprofile.edit') }}">My Profile</a>
                                                </li>
                                                <li>
                                                    <form method="POST" action="{{ route('logout') }}" style="display: none;" id="logout-form">
                                                        @csrf
                                                    </form>
                                                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                                </li>
                                            </ul>
                                        </li>
                                        @else
                                        <li>
                                            <a href="{{ route('login') }}" class="nav-link">Log In</a>
                                        </li>
                                        <li>
                                            @if (Route::has('register'))
                                                <a href="{{ route('register') }}" class="nav-link">Register</a>
                                            @endif
                                        </li>
                                        @endauth
                                        @endif
                                    </ul>
                                    
                                </nav>
                            </div>
                        </div>

                        
                        <!-- end: header nav menu -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>