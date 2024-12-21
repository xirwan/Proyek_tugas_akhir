@extends('layouts.main')

@section('content')
  <div class="container my-5">
    <h2 class="mb-4 text-center">Kegiatan</h2>
    <div class="row">

      @foreach($activities as $activity)
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            {{-- Poster (thumbnail) di dalam card --}}
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

            <div class="card-body">
              <h5 class="card-title">{{ $activity->title }}</h5>
              <p class="card-text">
                {{ Str::limit($activity->description, 100) }}
              </p>
              <p class="mb-1">
                <strong>Tanggal Mulai:</strong>
                {{ \Carbon\Carbon::parse($activity->start_date)->format('d M Y') }}
              </p>
              <p class="mb-1">
                <strong>Pendaftaran Dibuka:</strong>
                {{ \Carbon\Carbon::parse($activity->registration_open_date)->format('d M Y') }}
              </p>
              <p class="mb-1">
                <strong>Pendaftaran Ditutup:</strong>
                {{ \Carbon\Carbon::parse($activity->registration_close_date)->format('d M Y') }}
              </p>
              @if($activity->is_paid)
                <p class="mb-1">
                  <strong>Biaya:</strong> Rp {{ number_format($activity->price,0,',','.') }}
                </p>
                <p class="mb-1">
                  <strong>Batas Pembayaran:</strong>
                  {{ \Carbon\Carbon::parse($activity->payment_deadline)->format('d M Y') }}
                </p>
              @else
                <p class="mb-1">
                  <strong>Biaya:</strong> Gratis
                </p>
              @endif
            </div>

            {{-- Tombol untuk menampilkan poster di modal --}}
            <div class="card-footer text-center">
              <button 
                type="button" 
                class="btn btn-primary btn-sm"
                data-bs-toggle="modal" 
                data-bs-target="#posterModal-{{ $activity->id }}"
              >
                Lihat Poster
              </button>
            </div>
          </div>
        </div>

        <!-- Modal Poster (untuk setiap activity) -->
        <div 
          class="modal fade" 
          id="posterModal-{{ $activity->id }}" 
          tabindex="-1" 
          aria-labelledby="posterModalLabel-{{ $activity->id }}" 
          aria-hidden="true"
        >
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

              <div class="modal-header">
                <h5 class="modal-title" id="posterModalLabel-{{ $activity->id }}">
                  Poster Kegiatan
                </h5>
                <button 
                  type="button" 
                  class="btn-close" 
                  data-bs-dismiss="modal" 
                  aria-label="Close"
                ></button>
              </div>

              <div class="modal-body p-0">
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
        <!-- End Modal Poster -->
      @endforeach

    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
      {{ $activities->links() }}
    </div>
  </div>
@endsection