<x-user>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .badge-custom {
            font-size: 0.85rem;
            font-weight: bold;
        }
        .btn-group-custom {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;
        }
    </style>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <x-card>
        <x-slot name="header">
            Daftar Kegiatan
        </x-slot>

        <!-- Filter -->
        <form method="GET" action="{{ route('activities.member.index') }}" class="mb-4">
            <div class="row">
                <div class="col-lg-4">
                    <select name="is_paid" class="form-control">
                        <option value="">Semua Kegiatan</option>
                        <option value="1" {{ request('is_paid') == '1' ? 'selected' : '' }}>Berbayar</option>
                        <option value="0" {{ request('is_paid') == '0' ? 'selected' : '' }}>Tidak Berbayar</option>
                    </select>
                </div>
                <div class="col-lg-4">
                    <select name="is_registered" class="form-control">
                        <option value="">Semua Status Pendaftaran</option>
                        <option value="1" {{ request('is_registered') == '1' ? 'selected' : '' }}>Sudah Didaftarkan</option>
                        <option value="0" {{ request('is_registered') == '0' ? 'selected' : '' }}>Belum Didaftarkan</option>
                    </select>
                </div>
                <div class="col-lg-4">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('activities.member.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>

        <!-- Tabel Kegiatan -->
        <table class="table table-responsive-md mb-0 text-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Tanggal Kegiatan</th>
                    <th>Status</th>
                    <th>Mulai Pendaftaran</th>
                    <th>Tutup Pendaftaran</th>
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
                            @if ($activity->showRegisterButton)
                                <span class="badge bg-success text-white badge-custom">Tersedia untuk Pendaftaran</span>
                            @else
                                <span class="badge bg-secondary text-white badge-custom">Tidak Tersedia</span>
                            @endif
                        </td>
                        <td>{{ $activity->registration_open_date }}</td>
                        <td>{{ $activity->registration_close_date }}</td>
                        <td>
                            @if ($activity->poster_file)
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#posterModal-{{ $activity->id }}">
                                    Lihat Poster
                                </button>
                                <div class="modal fade" id="posterModal-{{ $activity->id }}" tabindex="-1" aria-labelledby="posterModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="posterModalLabel">Poster Kegiatan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times</button>
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
                            @if ($activity->showRegisterButton)
                                @if ($activity->is_paid)
                                    <a href="#" class="btn btn-success btn-sm">Daftar</a>
                                @else
                                    <a href="{{ route('activities.selfregisterfree.form', $activity->id) }}" class="btn btn-success btn-sm">Daftar</a>
                                @endif
                            @else
                                <span class="text-muted">Sudah Terdaftar</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">
                            <div class="alert alert-danger">
                                Tidak ada kegiatan yang tersedia.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-5">
            {{ $activities->links() }}
        </div>
    </x-card>
</x-user>