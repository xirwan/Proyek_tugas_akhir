{{-- <x-app-layout>
    <x-card>
        <x-slot name="header">
            Detail Aktivitas: {{ $activity->title }}
        </x-slot>
        @if ($activity->status === 'rejected')
            <div class="alert alert-danger">
                <strong>Alasan Penolakan:</strong> {{ $activity->rejection_reason }}
            </div>
        @endif
        <div class="mb-3">
            <strong>Judul:</strong> {{ $activity->title }}
        </div>
        <div class="mb-3">
            <strong>Deskripsi:</strong> {{ $activity->description ?? '-' }}
        </div>
        <div class="mb-3">
            <strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $activity->status)) }}
        </div>
        <div class="mb-3">
            <strong>Jumlah Peserta:</strong> {{ $activity->max_participants }}
        </div>
        <div class="mb-3">
            <strong>Tanggal Kegiatan:</strong> {{ $activity->start_date }}
        </div>
        <div class="mb-3">
            <strong>Tanggal Pendaftaran:</strong> {{ $activity->registration_open_date }} Hingga {{ $activity->registration_close_date }}
        </div>
        <div class="mb-3">
            <strong>Batas Pembayaran:</strong> {{ $activity->payment_deadline ?? 'Tidak Ada' }}
        </div>
        <div class="mb-3">
            <strong>Biaya:</strong> {{ $activity->is_paid ? 'Rp' . number_format($activity->price, 0, ',', '.') : 'Gratis' }}
        </div>
        <div class="mb-3">
            <strong>Proposal Kegiatan:</strong>
            @if ($activity->proposal_file)
                <a href="{{ asset('storage/' . $activity->proposal_file) }}" target="_blank" class="btn btn-primary btn-sm">Lihat Proposal Kegiatan</a>
            @else
                Tidak ada file proposal kegiatan
            @endif
        </div>
        <div class="mb-3">
            <strong>Poster Kegiatan:</strong>
            @if ($activity->poster_file)
                <a href="{{ asset('storage/' . $activity->poster_file) }}" target="_blank" class="btn btn-primary btn-sm">Lihat Poster Kegiatan</a>
            @else
                Tidak ada file poster kegiatan
            @endif
        </div>
        <a href="{{ route('activities.index') }}" class="btn btn-success">Kembali</a>
    </x-card>
</x-app-layout> --}}
<x-app-layout>
    <section class="card">
        <header class="card-header">
            <h2 class="card-title">Detail Aktivitas: {{ $activity->title }}</h2>
        </header>
        <div class="card-body">
            <div class="row form-group">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="is_paid" class="form-label">Apakah Berbayar?</label>
                        <select name="is_paid" id="is_paid" class="form-control" disabled>
                            <option value="0" {{ $activity->is_paid == 0 ? 'selected' : '' }}>Tidak</option>
                            <option value="1" {{ $activity->is_paid == 1 ? 'selected' : '' }}>Ya</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <x-input-number 
                        name="price" 
                        id="inputPrice" 
                        label="Biaya (Jika Berbayar)" 
                        placeholder="Masukkan biaya kegiatan" 
                        value="{{ $activity->is_paid == 0 && $activity->price == 0 ? '' : old('price', $activity->price) }}" 
                        min="0" 
                        step="5000" 
                        :disabled="true" 
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
                        :disabled="true"
                    />
                </div>
                <div class="col-lg-4">
                    <x-date-picker 
                        label="Tanggal Pendaftaran Dibuka" 
                        name="registration_open_date" 
                        :required="true" 
                        min="{{ date('Y-m-d') }}" 
                        max="{{ date('Y-m-d', strtotime('+1 year')) }}"
                        value="{{ old('registration_open_date', $activity->registration_open_date) }}"
                        :disabled="true"
                    />
                </div>
                <div class="col-lg-4">
                    <x-date-picker 
                        label="Tanggal Pendaftaran Ditutup" 
                        name="registration_close_date" 
                        :required="true" 
                        min="{{ date('Y-m-d') }}" 
                        max="{{ date('Y-m-d', strtotime('+1 year')) }}"
                        value="{{ old('registration_close_date', $activity->registration_close_date) }}"
                        :disabled="true"
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
                        value="{{ old('payment_deadline', $activity->payment_deadline) }}"
                        :disabled="true"
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
                        :disabled="true"
                    />
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-6">
                    <x-input-text 
                        name="title" 
                        id="inputTitle" 
                        label="Judul Kegiatan" 
                        placeholder="Masukkan judul kegiatan" 
                        :required="true"
                        value="{{ old('title', $activity->title) }}"
                        :disabled="true"
                    />
                </div>
                <div class="col-lg-6">
                    <x-input-area 
                        name="description" 
                        id="inputDescription" 
                        label="Deskripsi" 
                        placeholder="Masukkan deskripsi kegiatan"
                        value="{{ old('description', $activity->description) }}"
                        :disabled="true"
                    />
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-6">
                    <x-input-file 
                        name="proposal_file" 
                        label="Upload File Proposal Kegiatan (Max: 2 MB)" 
                        accept=".pdf,.doc,.docx" 
                        :disabled="true" 
                    />
                    @if ($activity->proposal_file)
                        <div class="mt-2">
                            <label class="form-label">Proposal yang Sudah Ada:</label>
                            <a href="{{ asset('storage/' . $activity->proposal_file) }}" target="_blank" class="btn btn-info btn-sm">
                                Lihat Proposal
                            </a>
                        </div>
                    @endif
                </div>
                <div class="col-lg-6">
                    <x-input-file 
                        name="poster_file" 
                        label="Upload File Poster Kegiatan (Max: 2 MB)" 
                        accept=".pdf,.jpeg,.gif,.jpg,.png" 
                        :disabled="true" 
                    />
                    @if ($activity->poster_file)
                        <div class="mt-2">
                            <label class="form-label">Poster kegiatan yang Sudah Ada:</label>
                            <a href="{{ asset('storage/' . $activity->poster_file) }}" target="_blank" class="btn btn-info btn-sm">
                                Lihat Poster
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <footer class="card-footer text-right">
            <a href="{{ route('activities.index') }}" class="btn btn-success">Kembali</a>
        </footer>
    </section>
</x-app-layout>