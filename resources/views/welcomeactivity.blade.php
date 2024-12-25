@extends('layouts.main')

@section('content')
  <!-- ========== SLIDESHOW ========== -->
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

  <!-- ========== LIST KEGIATAN ========== -->
  <div class="container my-5">
    <h2 class="mb-4 text-center">Kegiatan</h2>
    
    @if($activities->count() > 0)
      <div class="row">
        @foreach($activities as $activity)
          <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm animate__animated animate__fadeInUp">
              <!-- Poster Kegiatan -->
              @if($activity->poster_file)
                <img 
                  src="{{ asset('storage/'.$activity->poster_file) }}"
                  class="card-img-top"
                  style="object-fit:cover; height:200px;"
                  alt="Poster Kegiatan"
                >
              @else
                <img 
                  src="https://via.placeholder.com/600x400?text=No+Poster"
                  class="card-img-top"
                  alt="No Poster"
                >
              @endif

              <!-- Content -->
              <div class="card-body">
                <h5 class="card-title">{{ $activity->title }}</h5>
                <p class="card-text text-muted">
                  {{ Str::limit($activity->description, 100) }}
                </p>
                <ul class="list-unstyled">
                  <li><strong>Tanggal Mulai:</strong> {{ \Carbon\Carbon::parse($activity->start_date)->format('d M Y') }}</li>
                  <li><strong>Pendaftaran Dibuka:</strong> {{ \Carbon\Carbon::parse($activity->registration_open_date)->format('d M Y') }}</li>
                  <li><strong>Pendaftaran Ditutup:</strong> {{ \Carbon\Carbon::parse($activity->registration_close_date)->format('d M Y') }}</li>
                  @if($activity->is_paid)
                    <li><strong>Biaya:</strong> Rp {{ number_format($activity->price,0,',','.') }}</li>
                    <li><strong>Batas Pembayaran:</strong> {{ \Carbon\Carbon::parse($activity->payment_deadline)->format('d M Y') }}</li>
                  @else
                    <li><strong>Biaya:</strong> Gratis</li>
                  @endif
                </ul>
              </div>

              <!-- Footer -->
              <div class="card-footer text-center">
                <button 
                  type="button" 
                  class="btn btn-primary btn-sm"
                  data-bs-toggle="modal" 
                  data-bs-target="#detailsModal-{{ $activity->id }}"
                >
                  Lihat Detail
                </button>
                <button 
                  type="button" 
                  class="btn btn-secondary btn-sm"
                  data-bs-toggle="modal" 
                  data-bs-target="#posterModal-{{ $activity->id }}"
                >
                  Lihat Poster
                </button>
              </div>
            </div>
          </div>

          <!-- Modal Detail -->
          <div class="modal fade" id="detailsModal-{{ $activity->id }}" tabindex="-1" aria-labelledby="detailsModalLabel-{{ $activity->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="detailsModalLabel-{{ $activity->id }}">{{ $activity->title }}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p>{{ $activity->description }}</p>
                  <ul>
                    <li><strong>Tanggal Mulai:</strong> {{ \Carbon\Carbon::parse($activity->start_date)->format('d M Y') }}</li>
                    <li><strong>Pendaftaran Dibuka:</strong> {{ \Carbon\Carbon::parse($activity->registration_open_date)->format('d M Y') }}</li>
                    <li><strong>Pendaftaran Ditutup:</strong> {{ \Carbon\Carbon::parse($activity->registration_close_date)->format('d M Y') }}</li>
                    @if($activity->is_paid)
                      <li><strong>Biaya:</strong> Rp {{ number_format($activity->price,0,',','.') }}</li>
                      <li><strong>Batas Pembayaran:</strong> {{ \Carbon\Carbon::parse($activity->payment_deadline)->format('d M Y') }}</li>
                    @else
                      <li><strong>Biaya:</strong> Gratis</li>
                    @endif
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal Poster -->
          <div class="modal fade" id="posterModal-{{ $activity->id }}" tabindex="-1" aria-labelledby="posterModalLabel-{{ $activity->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="posterModalLabel-{{ $activity->id }}">Poster Kegiatan</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  @if($activity->poster_file)
                    <img 
                      src="{{ asset('storage/'.$activity->poster_file) }}"
                      alt="Poster Kegiatan" 
                      style="width:100%; object-fit:cover;"
                    />
                  @else
                    <img 
                      src="https://via.placeholder.com/600x400?text=No+Poster"
                      alt="No Poster" 
                      style="width:100%; object-fit:cover;"
                    />
                  @endif
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <!-- Pagination -->
      <div class="d-flex justify-content-center">
        {{ $activities->links() }}
      </div>
    @else
      <div class="text-center">
        <p class="fs-4 text-muted">Kegiatan tidak tersedia.</p>
      </div>
    @endif
  </div>
@endsection