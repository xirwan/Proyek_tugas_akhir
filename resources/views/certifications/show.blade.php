<x-app-layout>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div id="alert" class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <x-card>
        <x-slot name="header">
            Verifikasi Sertifikat
        </x-slot>

        <div class="card-body">
            {{-- Informasi Anggota --}}
            <h4>Informasi Anggota</h4>
            <p><strong>Nama:</strong> {{ $certification->member->firstname }} {{ $certification->member->lastname }}</p>
            <p><strong>Email:</strong> {{ $certification->member->user->email }}</p>
            <p><strong>Alamat:</strong> {{ $certification->member->address }}</p>

            {{-- Informasi Sertifikat --}}
            <h4>Sertifikat</h4>
            <div class="mb-3">
                <strong>Sertifikat Seminar:</strong>
                @if ($certification->seminar_file)
                    <a href="{{ Storage::url($certification->seminar_file) }}" target="_blank">Lihat File</a>
                @else
                    <span class="text-danger">Tidak Ada File</span>
                @endif
            </div>
            <div class="mb-3">
                <strong>Sertifikat Baptis:</strong>
                @if ($certification->baptism_file)
                    <a href="{{ Storage::url($certification->seminar_file) }}" target="_blank">Lihat File</a>
                @else
                    <span class="text-danger">Tidak Ada File</span>
                @endif
            </div>

            {{-- Form Verifikasi --}}
            <form action="{{ route('certifications.verify', encrypt($certification->id)) }}" method="POST" class="mb-3">
                @csrf
                <div class="form-check">
                    <input type="checkbox" name="seminar_certified" id="seminar_certified" class="form-check-input"
                        {{ $certification->seminar_certified ? 'checked' : '' }}>
                    <label for="seminar_certified" class="form-check-label">Verifikasi Sertifikat Seminar</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="baptism_certified" id="baptism_certified" class="form-check-input"
                        {{ $certification->baptism_certified ? 'checked' : '' }}>
                    <label for="baptism_certified" class="form-check-label">Verifikasi Sertifikat Baptis</label>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Simpan Verifikasi</button>
            </form>

            {{-- Form Penolakan --}}
            <form action="{{ route('certifications.reject', encrypt($certification->id)) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="rejection_reason">Alasan Penolakan</label>
                    <textarea name="rejection_reason" id="rejection_reason" rows="3" class="form-control @error('rejection_reason') is-invalid @enderror" required></textarea>
                    @error('rejection_reason')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-danger mt-3">Tolak Sertifikat</button>
            </form>
        </div>

        <footer class="card-footer text-right">
            <a href="{{ route('certifications.index') }}" class="btn btn-success">Kembali</a>
        </footer>
    </x-card>
</x-app-layout>