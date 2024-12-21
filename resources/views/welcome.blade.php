{{-- resources/views/landing.blade.php --}}
@extends('layouts.main')

@section('content')
  <!-- ========== HERO SECTION ========== -->
  <section class="hero">
    <div class="container">
      <h1>Selamat Datang di Sekolah Minggu</h1>
      <p>GBI Sungai Yordan</p>
    </div>
  </section>

  <!-- ========== MAIN CONTENT ========== -->
  <div class="container my-5">
    <div class="row">
      <div class="col text-center">
        <h2 class="mb-4" id="jadwal">Jadwal Sekolah Minggu</h2>
        <p>Berikut jadwal sekolah minggu GBI Sungai Yordan:</p>
      </div>
    </div>

    {{-- Contoh: Card + Table --}}
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