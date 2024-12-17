<x-app-layout>
    @if ($errors->any())
        <div id="alert" class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif
    <form method="POST" action="{{ route('seminars.store') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
        @csrf
        <section class="card">
            <header class="card-header">   
                <h2 class="card-title">Penambahan Seminar</h2>
            </header>
            <div class="card-body">
                <div class="row form-group">
                    <div class="col-lg-3">
                        <x-date-picker 
                            label="Tanggal Seminar" 
                            name="event_date" 
                            :required="true" 
                            min="{{ date('Y-m-d') }}" 
                        />
                    </div>
                    <div class="col-lg-3">
                        <x-time-picker name="start" label="Jam Mulai" :required="true" />
                    </div>
                    <div class="col-lg-3">
                        <x-date-picker 
                            label="Tanggal Pendaftaran Dibuka" 
                            name="registration_start" 
                            :required="true" 
                            min="{{ date('Y-m-d') }}" 
                            max="{{ date('Y-m-d', strtotime('+1 year')) }}"
                        />
                    </div>
                    <div class="col-lg-3">
                        <x-date-picker 
                            label="Tanggal Pendaftaran Ditutup" 
                            name="registration_end" 
                            :required="true" 
                            min="{{ date('Y-m-d') }}" 
                            max="{{ date('Y-m-d', strtotime('+1 year')) }}"
                        />
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-6">
                        {{-- Input Judul Kegiatan --}}
                        <x-input-text 
                            name="name" 
                            id="inputTitle" 
                            label="Judul Seminar" 
                            placeholder="Masukkan judul seminar" 
                            :required="true"
                        />
                    </div>
                    <div class="col-lg-6">
                        <x-input-area 
                            name="description" 
                            id="inputDescription" 
                            label="Deskripsi" 
                            placeholder="Masukkan deskripsi seminar"
                        />
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-6">
                        <x-input-number 
                            name="max_participants" 
                            id="inputMaxParticipants" 
                            label="Maksimal Peserta" 
                            placeholder="Masukkan jumlah maksimal peserta" 
                            value="{{ old('max_participants', $activity->max_participants ?? '') }}" 
                            min="1" 
                            step="1" 
                            required
                        />
                    </div>
                    <div class="col-lg-6">
                        <x-input-file name="poster_file" label="Upload File Poster Seminar (Max: 2 MB)" accept=".jpeg,.gif,.jpg,.png"  required/>
                    </div>
                </div>
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{{ route('seminars.index') }}" class="btn btn-success">Kembali</a>
            </footer>
        </section>
    </form>
</x-app-layout>
