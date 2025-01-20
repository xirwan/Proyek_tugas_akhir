{{-- resources/views/landing.blade.php --}}
@extends('layouts.main')

@section('content')
  <!-- ========== HERO SECTION ========== -->
  <section class="hero">
    <div class="container text-center">
      <h1>Selamat Datang di Sekolah Minggu</h1>
      <p>GBI Sungai Yordan</p>
    </div>
  </section>

  <!-- ========== VISI DAN MISI ========== -->
  <div class="container my-5" id="visi-misi">
    <div class="row text-center mb-5">
      <div class="col-12">
        <h2 class="fw-bold" style="color: #0d6efd; text-shadow: 1px 1px 2px rgba(0,0,0,0.2);">
          Visi dan Misi
        </h2>
        <p class="text-muted">Membangun Generasi Muda yang Beriman dan Berkarakter</p>
      </div>
    </div>
    <div class="row d-flex align-items-stretch">
      <!-- VISI -->
      <div class="col-md-6 mb-4">
        <div 
          class="card shadow-sm border-0 h-100" 
          style="background: linear-gradient(135deg, #0d6efd, #2b98f0); color: #fff;"
        >
          <div class="card-body text-center d-flex flex-column">
            <div class="mb-3">
              <i class="fa-solid fa-eye fa-3x"></i>
            </div>
            <h5 class="fw-bold">Visi</h5>
            <p class="mt-2">
              Menjadi komunitas rohani yang membawa anak-anak dan keluarga lebih dekat kepada Tuhan, 
              memupuk iman yang kuat, dan menanamkan nilai-nilai Kristiani dalam kehidupan sehari-hari.
            </p>
            <div class="mt-auto"></div>
          </div>
        </div>
      </div>

      <!-- MISI -->
      <div class="col-md-6 mb-4">
        <div 
          class="card shadow-sm border-0 h-100" 
          style="background: linear-gradient(135deg, #198754, #23b168); color: #fff;"
        >
          <div class="card-body text-center d-flex flex-column">
            <div class="mb-3">
              <i class="fa-solid fa-bullseye fa-3x"></i>
            </div>
            <h5 class="fw-bold">Misi</h5>
            <ul class="list-unstyled mt-2 text-start">
              <li>- Mengadakan kegiatan sekolah minggu yang menyenangkan dan mendidik.</li>
              <li>- Membimbing anak-anak untuk mengenal Tuhan Yesus lebih dalam.</li>
              <li>- Membangun komunitas yang saling mendukung secara rohani.</li>
              <li>- Mendorong keterlibatan keluarga dalam pembentukan iman anak-anak.</li>
            </ul>
            <div class="mt-auto"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ========== SECTION INFO: 3 Kolom Singkat ========== -->
  <div class="container my-5" id="info">
    <div class="row text-center">
      <div class="col-md-4 mb-4">
        <img 
          src="{{ asset('admintemp/img/boy.png') }}" 
          alt="icon1" 
          class="mb-3"
          style="width: 60px; height: 60px; object-fit: cover;"
        >
        <h5 class="fw-bold">Menyenangkan</h5>
        <p>Kegiatan pujian dan bimbingan interaktif yang membuat anak-anak betah.</p>
      </div>
      <div class="col-md-4 mb-4">
        <img 
          src="{{ asset('admintemp/img/pray.png') }}" 
          alt="icon2" 
          class="mb-3"
          style="width: 60px; height: 60px; object-fit: cover;"
        >
        <h5 class="fw-bold">Membangun Iman</h5>
        <p>Membantu membentuk karakter dan nilai-nilai Kristiani sejak dini.</p>
      </div>
      <div class="col-md-4 mb-4">
        <img 
          src="{{ asset('admintemp/img/family-member.png') }}" 
          alt="icon3" 
          class="mb-3"
          style="width: 60px; height: 60px; object-fit: cover;"
        >
        <h5 class="fw-bold">Komunitas</h5>
        <p>Memperluas pertemanan rohani bagi semua anggota keluarga.</p>
      </div>
    </div>
  </div>

  <!-- ========== SECTION CAROUSEL ========== -->
  <div class="container my-5">
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
      <!-- Indicators -->
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>

      <!-- Slides -->
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img 
            src="https://picsum.photos/1920/1080?random=1" 
            class="d-block w-100" 
            alt="Slide 1"
            style="object-fit: cover; height: 400px;"
          >
        </div>
        <div class="carousel-item">
          <img 
            src="https://picsum.photos/1920/1080?random=2" 
            class="d-block w-100" 
            alt="Slide 2"
            style="object-fit: cover; height: 400px;"
          >
        </div>
        <div class="carousel-item">
          <img 
            src="https://picsum.photos/1920/1080?random=3" 
            class="d-block w-100" 
            alt="Slide 3"
            style="object-fit: cover; height: 400px;"
          >
        </div>
      </div>

      <!-- Controls -->
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>

  <!-- ========== SECTION TABEL JADWAL ========== -->
  <div class="container my-5">
    <div class="row">
      <div class="col text-center">
        <h2 class="mb-4" id="jadwal">Jadwal Ibadah</h2>
        <p>Berikut jadwal Ibadah GBI Sungai Yordan:</p>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="card shadow-sm border-0">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Jadwal Ibadah</h5>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-striped table-hover mb-0">
                <thead class="bg-light">
                  <tr>
                    <th>Nama Jadwal</th>
                    <th>Tipe</th>
                    <th>Kategori</th>
                    <th>Hari</th>
                    <th>Jam</th>
                    <th>Deskripsi</th>
                  </tr>
                </thead>
                <tbody>
                  @if(isset($schedules) && $schedules->count() > 0)
                    @foreach($schedules as $schedule)
                      <tr>
                        <!-- Nama Jadwal -->
                        <td>{{ $schedule->name ?? '-' }}</td>

                        <!-- Tipe -->
                        <td>{{ $schedule->type->name ?? '-' }}</td>

                        <!-- Kategori -->
                        <td>{{ $schedule->category->name ?? '-' }}</td>

                        <!-- Hari -->
                        <td>{{ ucfirst($schedule->day) }}</td>

                        <!-- Jam -->
                        <td>
                          {{ \Carbon\Carbon::parse($schedule->start)->format('H:i') }}
                          -
                          {{ \Carbon\Carbon::parse($schedule->end)->format('H:i') }}
                        </td>

                        <!-- Deskripsi -->
                        <td>{{ $schedule->description ?? '-' }}</td>
                      </tr>
                    @endforeach
                  @else
                    <tr>
                      <td colspan="6" class="text-center">
                        Belum ada jadwal ibadah yang terdaftar.
                      </td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </div> <!-- end .table-responsive -->
          </div> <!-- end .card-body -->
        </div> <!-- end .card -->
      </div> <!-- end .col -->
    </div> <!-- end .row -->
  </div>

  <!-- ========== SECTION TABEL JADWAL KELAS ========== -->
  <div class="container my-5">
    <div class="row">
      <div class="col text-center">
        <h2 class="mb-4" id="jadwal">Jadwal Sekolah Minggu</h2>
        <p>Berikut jadwal sekolah minggu GBI Sungai Yordan:</p>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="card shadow-sm border-0">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Jadwal Kelas</h5>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-striped table-hover mb-0">
                <thead class="bg-light">
                  <tr>
                    <th>Hari</th>
                    <th>Jam</th>
                    <th>Nama Kelas</th>
                  </tr>
                </thead>
                <tbody>
                  @if(isset($classes) && $classes->count() > 0)
                    @foreach($classes as $class)
                      @foreach($class->schedules as $schedule)
                        <tr>
                          {{-- Hari --}}
                          <td>{{ ucfirst($schedule->day) }}</td>

                          {{-- Jam --}}
                          <td>
                            {{ \Carbon\Carbon::parse($schedule->start)->format('H:i') }}
                            -
                            {{ \Carbon\Carbon::parse($schedule->end)->format('H:i') }}
                          </td>

                          {{-- Nama Kelas --}}
                          <td>{{ $class->name }}</td>
                        </tr>
                      @endforeach
                    @endforeach
                  @else
                    <tr>
                      <td colspan="3" class="text-center">
                        Belum ada jadwal sekolah minggu yang terdaftar.
                      </td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </div> <!-- end .table-responsive -->
          </div> <!-- end .card-body -->
        </div> <!-- end .card -->
      </div> <!-- end .col -->
    </div> <!-- end .row -->
  </div>

@endsection