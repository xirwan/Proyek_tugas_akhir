<x-app-layout>
    @if ($errors->any())
        <div id="alert" class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif
    <form method="POST" action="{{ route('activities.store') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
        @csrf
        <section class="card">
            <header class="card-header">   
                <h2 class="card-title">Pengajuan Kegiatan</h2>
            </header>
            <div class="card-body">
                <div class="row form-group">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="is_paid" class="form-label">Apakah Berbayar?</label>
                            <select name="is_paid" id="is_paid" class="form-control">
                                <option value="0" {{ old('is_paid') == '0' ? 'selected' : '' }}>Tidak</option>
                                <option value="1" {{ old('is_paid') == '1' ? 'selected' : '' }}>Ya</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <x-input-number 
                            name="price" 
                            id="inputPrice" 
                            label="Biaya (Jika Berbayar)" 
                            placeholder="Masukkan biaya kegiatan" 
                            value="{{ old('price') }}" 
                            min="0" 
                            step="5000" 
                        />
                    </div>
                    <div class="col-lg-4">
                        <x-input-num 
                            label="Nomor Rekening" 
                            name="account_number" 
                            id="account_number" 
                            placeholder="Masukkan nomor rekening Anda" 
                            maxlength="16" 
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
                        />
                    </div>
                    <div class="col-lg-4">
                        <x-date-picker 
                            label="Tanggal Pendaftaran Dibuka" 
                            name="registration_open_date" 
                            :required="true" 
                            min="{{ date('Y-m-d') }}" 
                            max="{{ date('Y-m-d', strtotime('+1 year')) }}"
                        />
                    </div>
                    <div class="col-lg-4">
                        <x-date-picker 
                            label="Tanggal Pendaftaran Ditutup" 
                            name="registration_close_date" 
                            :required="true" 
                            min="{{ date('Y-m-d') }}" 
                            max="{{ date('Y-m-d', strtotime('+1 year')) }}"
                        />
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-6">
                        <x-date-picker 
                            label="Batas Waktu Pembayaran (Jika Berbayar)" 
                            name="payment_deadline" 
                            min="{{ date('Y-m-d') }}" 
                            max="{{ date('Y-m-d', strtotime('+1 year')) }}"
                        />
                    </div>
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
                        />
                    </div>
                    <div class="col-lg-6">
                        <x-input-area 
                            name="description" 
                            id="inputDescription" 
                            label="Deskripsi" 
                            placeholder="Masukkan deskripsi kegiatan"
                        />
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-6">
                        <x-input-file name="proposal_file" label="Upload File Proposal Kegiatan (Max: 2 MB)" accept=".pdf,.doc,.docx" required/>
                    </div>
                    <div class="col-lg-6">
                        <x-input-file name="poster_file" label="Upload File Poster Kegiatan (Max: 2 MB)" accept=".pdf,.jpeg,.gif,.jpg,.png"  required/>
                    </div>
                </div>
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{{ route('activities.index') }}" class="btn btn-success">Kembali</a>
            </footer>
        </section>
    </form>
</x-app-layout>
