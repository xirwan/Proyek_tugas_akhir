{{-- resources/views/layouts/main.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>GBI Sungai Yordan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link 
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    />

    <style>
      /* Tempatkan CSS khusus di sini (hero, navbar hover, dll.) */

      /* Hero Section */
      .hero {
        background-image: url("{{ asset('admintemp/img/landing.jpg') }}");
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        min-height: 60vh;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        text-align: center;
      }

      .hero h1 {
        font-size: 3rem;
        font-weight: 700;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.6);
      }
      .hero p {
        font-size: 1.2rem;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.6);
      }

      .navbar-dark .navbar-nav .nav-link {
        position: relative;
        color: #fff;
        transition: color 0.2s ease;
        /* Boleh tambahkan padding, margin, dll. */
        margin: 0 0.025rem; 
        padding: 0.5rem;
      }

      /* Buat garis di bawah teks (mulai width:0, lalu melebar saat hover) */
      .navbar-dark .navbar-nav .nav-link::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: 0;
        width: 0%;
        height: 2px;
        background-color: #0d6efd;
        transition: width 0.2s ease;
      }

      /* Saat hover, lebarkan garis hingga 100% */
      .navbar-dark .navbar-nav .nav-link:hover::after {
        width: 100%;
      }

      /* Agar teks berubah warna saat hover */
      .navbar-dark .navbar-nav .nav-link:hover {
        color: #0d6efd;
      }


      
    </style>
</head>
<body>
  {{-- NAVBAR --}}
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
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

          {{-- JADWAL SEKOLAH MINGGU (Scroll ke #jadwal di landing) --}}
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/') }}#jadwal">Jadwal Sekolah Minggu</a>
          </li>

          {{-- LINK KE HALAMAN ACTIVITY --}}
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
            @role('SuperAdmin|Admin')
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle"
                   href="#"
                   id="adminDropdown"
                   role="button"
                   data-bs-toggle="dropdown"
                   aria-expanded="false">
                  {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                  <li>
                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                      Dashboard
                    </a>
                  </li>
                  <li><hr class="dropdown-divider"></li>
                  <li>
                    <form method="POST" action="{{ route('logout') }}">
                      @csrf
                      <button type="submit" class="dropdown-item">
                        Logout
                      </button>
                    </form>
                  </li>
                </ul>
              </li>
            @endrole

            @role('Jemaat')
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle"
                   href="#"
                   id="jemaatDropdown"
                   role="button"
                   data-bs-toggle="dropdown"
                   aria-expanded="false">
                  {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="jemaatDropdown">
                  <li>
                    <a class="dropdown-item" href="{{ route('portal') }}">
                      Portal
                    </a>
                  </li>
                  <li><hr class="dropdown-divider"></li>
                  <li>
                    <form method="POST" action="{{ route('logout') }}">
                      @csrf
                      <button type="submit" class="dropdown-item">
                        Logout
                      </button>
                    </form>
                  </li>
                </ul>
              </li>
            @endrole
          @endauth
        </ul>
      </div>
    </div>
  </nav>

  {{-- BAGIAN UTAMA (akan di-override) --}}
  <main>
    @yield('content')
  </main>

  {{-- FOOTER --}}
  <footer class="bg-dark text-center text-white py-3">
    <div>
      <img
        src="{{ asset('admintemp/img/logo.png') }}"
        alt="Logo GBI"
        style="height:80px; border-radius:50%; object-fit:cover;"
      />
    </div>
    <p class="mt-2 mb-0">
      &copy; {{ date('Y') }} GBI Sungai Yordan. All rights reserved.
    </p>
  </footer>

  <script 
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
  </script>
</body>
</html>