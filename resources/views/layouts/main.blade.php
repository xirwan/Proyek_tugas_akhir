{{-- resources/views/layouts/main.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="{{ asset('admintemp/img/logo.jpg') }}" type="image/png">
    <meta charset="utf-8">
    <title>GBI Sungai Yordan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link 
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    />

    <link 
      rel="stylesheet" 
      href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />

    <link 
      rel="stylesheet" 
      href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css"
      integrity="sha512-Ho3XqikA9z2bhtNxL7KFKxryJ0pqul9CDiHA7Zuo9pmk5Flxj8DqPPj88RhmvgIEyrwH+juo8fRU5l/Z3SBUsw==" 
      crossorigin="anonymous" 
      referrerpolicy="no-referrer" 
    />

    <!-- FA (ikon sosial media, dsb.) -->
    <link 
      rel="stylesheet"
      href="{{ asset('landing/css/all.min.css') }}"
    />

    <style>
      /* =================== HERO SECTION =================== */
      /* Awalnya, hero hanya menata tata letak */
      .hero {
        position: relative;   
        overflow: hidden;     /* mencegah pseudo-element keluar dari kontainer */
        min-height: 60vh;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        text-align: center;
      }

      /* Pseudo-element untuk background */
      .hero::before {
        content: "";
        position: absolute;
        inset: 0; /* top:0; right:0; bottom:0; left:0 */
        background: url("{{ asset('admintemp/img/landing.jpg') }}") center/cover no-repeat;
        opacity: 0;
        animation: fadeInBg 3s ease forwards; /* Durasi 2s, silakan ubah sesuka hati */
      }

      /* Keyframes fadeInBg */
      @keyframes fadeInBg {
        0% {
          opacity: 0;
        }
        100% {
          opacity: 1;
        }
      }

      /* Animasi fadeIn untuk teks (h1, p) tetap ada seperti sebelumnya */
      @keyframes fadeIn {
        0% {
          opacity: 0;
          transform: translateY(20px);
        }
        100% {
          opacity: 1;
          transform: translateY(0);
        }
      }
      .hero h1,
      .hero p {
        text-shadow: 1px 1px 3px rgba(0,0,0,0.6);
        animation: fadeIn 1s ease forwards;
      }

      .hero h1 {
        font-size: 3rem;
        font-weight: 700;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.6);
      }
      .hero p {
        font-size: 1.2rem;
      }

      /* =================== NAVBAR =================== */
      .navbar-dark .navbar-nav .nav-link {
        position: relative;
        color: #fff;
        transition: color 0.2s ease;
        margin: 0 0.025rem; 
        padding: 0.5rem;
      }

      /* Garis tipis di bawah teks yang muncul saat hover */
      .navbar-dark .navbar-nav .nav-link:not(.dropdown-toggle)::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: 0;
        width: 0%;
        height: 2px;
        background-color: #0d6efd;
        transition: width 0.2s ease;
      }
      /* Efek garis memanjang hanya untuk nav-link biasa, bukan dropdown */
      .navbar-dark .navbar-nav .nav-link:not(.dropdown-toggle):hover::after {
        width: 100%;
      }

      /* Perubahan warna teks hanya untuk nav-link biasa, bukan dropdown */
      .navbar-dark .navbar-nav .nav-link:not(.dropdown-toggle):hover {
        color: #0d6efd;
      }
      .navbar-dark .navbar-nav .nav-link.dropdown-toggle::after {
        background: none !important;
        box-shadow: none !important;
      }
      /* =================== FOOTER =================== */
      .footer-logo {
        height:60px; 
        border-radius:50%; 
        object-fit:cover;
      }
      .footer-hr {
        opacity: 0.25; 
      }
      .footer-link {
      position: relative;
      color: #fff;              /* Warna teks default */
      transition: color 0.2s ease;
      display: inline-block;    /* Pastikan inline-block agar efek garis bekerja */
      padding-bottom: 2px;      /* Ruang di bawah teks untuk garis */
      margin: 0.25rem 0;
      text-decoration: none;
    }
    .footer-link::after {
      content: "";
      position: absolute;
      left: 0;
      bottom: 0;
      width: 0%;
      height: 2px;
      background-color: #0d6efd; /* Warna garis bawah (bisa Anda ubah) */
      transition: width 0.2s ease;
    }
    .footer-link:hover::after {
      width: 100%;
    }
    .footer-link:hover {
      color: #0d6efd;           /* Warna teks saat hover (sesuai navbar) */
    }
    .card {
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease-in-out;
    }

    .card:hover {
        transform: scale(1.05); /* Zoom efek saat hover */
    }
    </style>
</head>
<body>
  {{-- ================== NAVBAR ================== --}}
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <!-- Brand -->
      <a class="navbar-brand d-flex align-items-center" href="#">
        <img
          src="{{ asset('admintemp/img/logo.png') }}"
          alt="Logo GBI"
          style="height: 40px; margin-right: 8px; border-radius: 50%; object-fit: cover;"
        />
        <span>GBI Sungai Yordan</span>
      </a>

      <button 
        class="navbar-toggler" 
        type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#navbarContent"
        aria-controls="navbarContent" 
        aria-expanded="false" 
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav ms-auto">
          {{-- HOME --}}
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/') }}">Home</a>
          </li>

          {{-- SCROLL KE #jadwal DI LANDING --}}
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/') }}#jadwal">Jadwal Sekolah Minggu</a>
          </li>

          {{-- HALAMAN ACTIVITY (LANDING ACTIVITIES) --}}
          <li class="nav-item">
            <a class="nav-link" href="{{ route('landing-activities.index') }}">
              Kegiatan
            </a>
          </li>

          {{-- GUEST --}}
          @guest
            <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('register') }}">Register</a>
            </li>
          @endguest

          {{-- AUTH --}}
          @auth
            {{-- SuperAdmin dan Admin --}}
            @role('SuperAdmin|Admin')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <i class="fa-solid fa-chart-line me-2"></i> Dashboard
                    </a>
                </li>
            @endrole

            {{-- Jemaat --}}
            @role('Jemaat')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('portal') }}">
                        <i class="fa-solid fa-door-open me-2"></i> Portal
                    </a>
                </li>
            @endrole
            {{-- Dropdown untuk semua pengguna --}}
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle"
                  href="#"
                  id="userDropdown"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <i class="fa-solid fa-user me-2"></i> {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fa-solid fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
          @endauth

        </ul>
      </div>
    </div>
  </nav>
  {{-- =============== END NAVBAR =============== --}}

  {{-- =============== BAGIAN UTAMA =============== --}}
  <main>
    @yield('content')
  </main>
  {{-- ============== END BAGIAN UTAMA ============ --}}

  {{-- ================== FOOTER ================== --}}
  {{-- ================== FOOTER ================== --}}
  <footer class="bg-dark text-white pt-4 pb-2">
    <div class="container">
      <div class="row">
        <!-- Info Gereja -->
        <div 
          class="col-md-4 mb-3 d-flex flex-column align-items-center justify-content-center text-center"
          style="min-height: 150px;"
        >
          <img 
            src="{{ asset('admintemp/img/logo.png') }}" 
            alt="Logo GBI"
            class="footer-logo"
          />
          <h6 class="mt-2">GBI Sungai Yordan</h6>
        </div>
  
        <!-- Menu -->
        <div class="col-md-4 mb-3">
          <h6>Menu</h6>
          <ul class="list-unstyled">
            <li>
              <a href="{{ url('/') }}" class="footer-link text-white text-decoration-none">
                Home
              </a>
            </li>
            <li>
              <a href="{{ url('/') }}#jadwal" class="footer-link text-white text-decoration-none">
                Jadwal
              </a>
            </li>
            <li>
              <a href="{{ route('landing-activities.index') }}" class="footer-link text-white text-decoration-none">
                Kegiatan
              </a>
            </li>
          </ul>
        </div>
  
        <!-- Sosial Media -->
        <div class="col-md-4 mb-3">
          <h6>Ikuti Kami</h6>
          <a href="#" class="footer-link text-white text-decoration-none d-inline-block mb-1">
            <i class="fa-brands fa-facebook-f me-2"></i> Facebook
          </a>
          <br>
          <a href="#" class="footer-link text-white text-decoration-none d-inline-block mb-1">
            <i class="fa-brands fa-instagram me-2"></i> Instagram
          </a>
          <br>
          <a href="#" class="footer-link text-white text-decoration-none d-inline-block mb-1">
            <i class="fa-brands fa-youtube me-2"></i> YouTube
          </a>
        </div>
      </div>
  
      <div class="text-center mt-3">
        <hr class="footer-hr">
        <p class="mt-2 mb-0 small">
          &copy; {{ date('Y') }} GBI Sungai Yordan. All rights reserved.
        </p>
      </div>
    </div>
  </footer>
  {{-- ================ END FOOTER ================= --}}


  <script 
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
  </script>
</body>
</html>