<x-user>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .badge-custom {
            font-size: 1.2rem;
            font-weight: bold;
        }
    </style>
    {{-- Pesan Sukses --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filter Pencarian --}}
    <x-card>
        <x-slot name="header">
            Daftar Kegiatan
        </x-slot>

        <form method="GET" action="{{ route('activities.parent.index') }}" class="mb-4">
            <div class="row">
                <div class="col-lg-4">
                    <select name="is_paid" class="form-control">
                        <option value="">Semua Kegiatan</option>
                        <option value="1" {{ request('is_paid') == '1' ? 'selected' : '' }}>Berbayar</option>
                        <option value="0" {{ request('is_paid') == '0' ? 'selected' : '' }}>Tidak Berbayar</option>
                    </select>
                </div>
                <div class="col-lg-4">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('activities.parent.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>

        {{-- Tabel Data --}}
        <table class="table table-responsive-md mb-0 text-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Tanggal Mulai</th>
                    <th>Status</th>
                    <th>Poster</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activities as $activity)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $activity->title }}</td>
                        <td>{{ $activity->description ?? '-' }}</td>
                        <td>{{ $activity->start_date }}</td>
                        <td>
                            @php
                                $isRegistered = $registeredChildren->contains('activity_id', $activity->id);
                            @endphp
                            @if ($isRegistered)
                                <span class="badge bg-success text-white badge-custom">Sudah Didaftarkan</span>
                            @else
                                <span class="badge bg-secondary text-white badge-custom">Belum Didaftarkan</span>
                            @endif
                        </td>
                        <td>
                            {{-- Tombol untuk melihat poster kegiatan --}}
                            @if ($activity->poster_file)
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#posterModal-{{ $activity->id }}">
                                    Lihat Poster
                                </button>

                                {{-- Modal Poster --}}
                                <div class="modal fade" id="posterModal-{{ $activity->id }}" tabindex="-1" aria-labelledby="posterModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="posterModalLabel">Poster Kegiatan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <img src="{{ asset('storage/' . $activity->poster_file) }}" class="img-fluid" alt="Poster Kegiatan">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <span class="text-muted">Tidak Ada Poster</span>
                            @endif
                        </td>
                        <td>
                            {{-- Tombol Detail --}}
                            <a href="{{ route('activities.parent.show', $activity->id) }}" class="btn btn-primary btn-sm">Detail</a>

                            {{-- Tombol Daftar --}}
                            @if ($activity->showRegisterButton)
                                <a href="{{ route('activities.register.form', $activity->id) }}" class="btn btn-success btn-sm">Daftar</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            <div class="alert alert-danger">
                                Tidak ada kegiatan yang tersedia.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Navigasi Pagination --}}
        <div class="mt-5">
            {{ $activities->links() }}
        </div>
    </x-card>
</x-user>
