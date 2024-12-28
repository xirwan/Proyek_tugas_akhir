<x-app-layout>
    @if ($errors->any())
        <div id="alert" class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif
    <form method="POST" action="{{ route('activities.update', $activity->id) }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- Metode HTTP untuk update --}}
        <section class="card">
            <header class="card-header">   
                <h2 class="card-title">Edit Pengajuan Kegiatan</h2>
            </header>
            <div class="card-body">
                <div class="row form-group">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="is_paid" class="form-label">Apakah Berbayar?</label>
                            <select name="is_paid" id="is_paid" class="form-control">
                                <option value="0" {{ $activity->is_paid == 0 ? 'selected' : '' }}>Tidak</option>
                                <option value="1" {{ $activity->is_paid == 1 ? 'selected' : '' }}>Ya</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        {{-- Tampilkan biaya kosong jika tidak berbayar dan biaya = 0.00 --}}
                        <x-input-number 
                            name="price" 
                            id="inputPrice" 
                            label="Biaya (Jika Berbayar)" 
                            placeholder="Masukkan biaya kegiatan" 
                            value="{{ $activity->is_paid == 0 && $activity->price == 0 ? '' : old('price', $activity->price) }}" 
                            min="0" 
                            step="5000" 
                        />
                    </div>
                    <div class="col-lg-4">
                        {{-- Tampilkan biaya kosong jika tidak berbayar dan biaya = 0.00 --}}
                        <x-input-num 
                            label="Nomor Rekening" 
                            name="account_number" 
                            id="account_number" 
                            placeholder="Masukkan nomor rekening Anda" 
                            maxlength="16" 
                            value="{{ $activity->account_number }}"
                        />
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-4">
                        <x-date-picker 
                            label="Tanggal Kegiatan" 
                            name="start_date" 
                            :required="true" 
                            min="{{ date('Y-m-d') }}" 
                            value="{{ old('start_date', $activity->start_date) }}"
                        />
                    </div>
                    <div class="col-lg-4">
                        <x-date-picker 
                            label="Tanggal Pendaftaran Dibuka" 
                            name="registration_open_date" 
                            :required="true" 
                            min="{{ $activity->registration_open_date < now()->format('Y-m-d') ? $activity->registration_open_date : now()->format('Y-m-d') }}" 
                            max="{{ date('Y-m-d', strtotime('+1 year')) }}"
                            value="{{ old('registration_open_date', $activity->registration_open_date) }}"
                        />
                        @if ($activity->registration_open_date < now()->format('Y-m-d'))
                            <small class="text-muted">Tanggal pendaftaran sudah berlalu, Anda masih bisa mengeditnya.</small>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <x-date-picker 
                            label="Tanggal Pendaftaran Ditutup" 
                            name="registration_close_date" 
                            :required="true" 
                            min="{{ $activity->registration_close_date < now()->format('Y-m-d') ? $activity->registration_close_date : now()->format('Y-m-d') }}" 
                            max="{{ date('Y-m-d', strtotime('+1 year')) }}"
                            value="{{ old('registration_close_date', $activity->registration_close_date) }}"
                        />
                        @if ($activity->registration_close_date < now()->format('Y-m-d'))
                            <small class="text-muted">Tanggal penutupan sudah berlalu, Anda masih bisa mengeditnya.</small>
                        @endif
                    </div>
                </div>                
                <div class="row form-group">
                    <div class="col-lg-6">
                        <x-date-picker 
                            label="Batas Waktu Pembayaran (Jika Berbayar)" 
                            name="payment_deadline" 
                            min="{{ date('Y-m-d') }}" 
                            max="{{ date('Y-m-d', strtotime('+1 year')) }} "
                            value="{{ old('payment_deadline', $activity->payment_deadline) }}"
                        />
                    </div>
                    <div class="col-lg-6">
                        <x-input-number 
                            name="max_participants" 
                            id="inputMaxParticipants" 
                            label="Maksimal Peserta" 
                            placeholder="Masukkan jumlah maksimal peserta" 
                            value="{{ old('max_participants', $activity->max_participants) }}" 
                            min="1" 
                            step="1" 
                            required
                        />
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-6">
                        {{-- Input Judul Kegiatan --}}
                        <x-input-text 
                            name="title" 
                            id="inputTitle" 
                            label="Judul Kegiatan" 
                            placeholder="Masukkan judul kegiatan" 
                            :required="true"
                            value="{{ old('title', $activity->title) }}"
                        />
                    </div>
                    <div class="col-lg-6">
                        <x-input-area 
                            name="description" 
                            id="inputDescription" 
                            label="Deskripsi" 
                            placeholder="Masukkan deskripsi kegiatan"
                            value="{{ old('description', $activity->description) }}"
                        />
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-6">
                        <x-input-file 
                            name="proposal_file" 
                            label="Upload File Proposal Kegiatan (Max: 2 MB)" 
                            accept=".pdf,.doc,.docx" 
                        />
                        @if ($activity->proposal_file)
                            <div class="mt-2">
                                <label class="form-label">Proposal yang Sudah Ada:</label>
                                <a href="{{ asset('storage/' . $activity->proposal_file) }}" target="_blank" class="btn btn-info btn-sm">
                                    Lihat Proposal
                                </a>
                                <p class="text-muted mt-1">Jika Anda mengunggah file baru, file ini akan diganti.</p>
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-6">
                        <x-input-file 
                            name="poster_file" 
                            label="Upload File Poster Kegiatan (Max: 2 MB)" 
                            accept=".pdf,.jpeg,.gif,.jpg,.png" 
                        />
                        @if ($activity->poster_file)
                            <div class="mt-2">
                                <label class="form-label">Poster kegiatan yang Sudah Ada:</label>
                                <a href="{{ asset('storage/' . $activity->poster_file) }}" target="_blank" class="btn btn-info btn-sm">
                                    Lihat Poster
                                </a>
                                <p class="text-muted mt-1">Jika Anda mengunggah file baru, file ini akan diganti.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('activities.index') }}" class="btn btn-success">Kembali</a>
            </footer>
        </section>
    </form>
</x-app-layout>
