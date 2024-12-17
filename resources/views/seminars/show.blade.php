<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @if ($errors->any())
        <div id="alert" class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif

    @php
        $isEventPassed = now()->greaterThan($seminar->event_date);
    @endphp

    <form method="POST" action="{{ route('seminars.update', $seminar->id) }}" 
          class="form-horizontal form-bordered" 
          enctype="multipart/form-data">

        @csrf
        @method('PUT')
        <section class="card">
            <header class="card-header">
                <h2 class="card-title">Detail Seminar</h2>
            </header>
            <div class="card-body">
                <div class="row form-group">
                    <div class="col-lg-3">
                        <x-date-picker 
                            label="Tanggal Seminar" 
                            name="event_date" 
                            :required="true" 
                            min="{{ date('Y-m-d') }}" 
                            value="{{ old('event_date', \Carbon\Carbon::parse($seminar->event_date)->format('Y-m-d')) }}"
                            :disabled="$isEventPassed"
                        />
                    </div>
                    <div class="col-lg-3">
                        <x-time-picker 
                            name="start" 
                            label="Jam Mulai" 
                            :required="true" 
                            value="{{ old('start', \Carbon\Carbon::parse($seminar->start)->format('H:i')) }}"
                            :disabled="$isEventPassed"
                        />
                    </div>
                    <div class="col-lg-3">
                        <x-date-picker 
                            label="Tanggal Pendaftaran Dibuka" 
                            name="registration_start" 
                            :required="true" 
                            value="{{ old('registration_start', \Carbon\Carbon::parse($seminar->registration_start)->format('Y-m-d')) }}"
                            min="{{ date('Y-m-d') }}" 
                            max="{{ date('Y-m-d', strtotime('+1 year')) }}"
                            :disabled="$isEventPassed"
                        />
                    </div>
                    <div class="col-lg-3">
                        <x-date-picker 
                            label="Tanggal Pendaftaran Ditutup" 
                            name="registration_end" 
                            :required="true" 
                            value="{{ old('registration_end', \Carbon\Carbon::parse($seminar->registration_end)->format('Y-m-d')) }}"
                            min="{{ date('Y-m-d') }}" 
                            max="{{ date('Y-m-d', strtotime('+1 year')) }}"
                            :disabled="$isEventPassed"
                        />
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-6">
                        <x-input-text 
                            name="name" 
                            label="Judul Seminar" 
                            placeholder="Masukkan judul seminar" 
                            value="{{ old('name', $seminar->name) }}" 
                            :required="true"
                            :disabled="$isEventPassed"
                        />
                    </div>
                    <div class="col-lg-6">
                        <x-input-area 
                            name="description" 
                            id="inputDescription" 
                            label="Deskripsi" 
                            placeholder="Masukkan deskripsi seminar"
                            :required="true"
                            value="{{ old('description', $seminar->description) }}"
                            :disabled="$isEventPassed"
                        />
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-6">
                        <x-input-number 
                            name="max_participants" 
                            label="Maksimal Peserta" 
                            placeholder="Jumlah maksimal peserta" 
                            value="{{ old('max_participants', $seminar->max_participants) }}" 
                            min="1" 
                            :required="true"
                            :disabled="$isEventPassed"
                        />
                    </div>
                    <div class="col-lg-6">
                        <x-input-file 
                            name="poster_file" 
                            label="Upload Poster (Max: 2 MB)" 
                            accept=".jpeg,.jpg,.png"
                            :disabled="$isEventPassed"
                        />
                        @if ($seminar->poster_file)
                            <!-- Tombol Lihat Poster Lama -->
                            <button type="button" class="btn btn-sm btn-primary mt-2" data-toggle="modal" data-target="#posterModal">
                                Lihat Poster
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Modal Popup untuk Poster -->
            @if ($seminar->poster_file)
                <div class="modal fade" id="posterModal" tabindex="-1" role="dialog" aria-labelledby="posterModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="posterModalLabel">Poster Seminar</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center">
                                <img src="{{ asset('storage/' . $seminar->poster_file) }}" class="img-fluid" alt="Poster Seminar">
                            </div>
                            <div class="modal-footer">
                                <a href="{{ asset('storage/' . $seminar->poster_file) }}" download class="btn btn-primary">
                                    Download Poster
                                </a>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <footer class="card-footer text-right">
                @if (!$isEventPassed)
                    <button type="submit" class="btn btn-primary">Edit</button>
                @endif
                <a href="{{ route('seminars.index') }}" class="btn btn-success">Kembali</a>
            </footer>
        </section>
    </form>
</x-app-layout>
