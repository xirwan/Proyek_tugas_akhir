<x-app-layout>
    <style>
        .badge-custom {
            font-size: 1.2rem;
            font-weight: bold;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <x-card>
        <x-slot name="header">
            List Pengajuan Kegiatan
        </x-slot>

        {{-- Tombol Ajukan Kegiatan --}}
        @if (auth()->user()->hasRole('Admin')) {{-- Tombol hanya muncul untuk Admin --}}
            <div class="mb-4 text-end">
                <a href="{{ route('activities.create') }}" class="btn btn-success">Ajukan Kegiatan</a>
            </div>
        @endif

        {{-- Filter Form --}}
        <form method="GET" action="{{ route('activities.index') }}" class="mb-4">
            <div class="row">
                <div class="col-lg-3">
                    <select name="status" class="form-control">
                        <option value="">Pilih Status</option>
                        <option value="pending_approval" {{ request('status') === 'pending_approval' ? 'selected' : '' }}>Pending Approval</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                @if (auth()->user()->hasRole('SuperAdmin')) {{-- Filter tambahan untuk SuperAdmin --}}
                    <div class="col-lg-3">
                        <select name="admin_id" class="form-control">
                            <option value="">Pilih Pembina</option>
                            @foreach ($admins as $admin)
                                <option value="{{ $admin->id }}" {{ request('admin_id') == $admin->id ? 'selected' : '' }}>
                                    {{ $admin->firstname }} {{ $admin->lastname }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <div class="col-lg-4">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('activities.index') }}" class="btn btn-secondary">Reset</a>
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
                    <th>Status</th>
                    @if (auth()->user()->hasRole('SuperAdmin')) {{-- Kolom Pembina hanya untuk SuperAdmin --}}
                        <th>Pembina</th>
                    @endif
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activities as $activity)
                    <tr>
                        <td>{{ $loop->iteration + $activities->firstItem() - 1 }}</td>
                        <td>{{ $activity->title }}</td>
                        <td>{{ $activity->description ?? '-' }}</td>
                        <td>
                            @if ($activity->status === 'pending_approval')
                                <span class="badge bg-warning text-white badge-custom">Pending Approval</span>
                            @elseif ($activity->status === 'approved')
                                <span class="badge bg-success text-white badge-custom">Approved</span>
                            @elseif ($activity->status === 'rejected')
                                <span class="badge bg-danger text-white badge-custom">Rejected</span>
                            @endif
                        </td>
                        @if (auth()->user()->hasRole('SuperAdmin')) {{-- Menampilkan kolom Pembina hanya untuk SuperAdmin --}}
                            <td>{{ $activity->creator->firstname }} {{ $activity->creator->lastname }}</td>
                        @endif
                        <td>
                            <a href="{{ route('activities.show', $activity->id) }}" class="btn btn-primary btn-sm">Detail</a>
                            @if (auth()->user()->hasRole('SuperAdmin') && $activity->status === 'pending_approval')
                                {{-- Tombol Setujui untuk SuperAdmin --}}
                                <form method="POST" action="{{ route('activities.approve', $activity->id) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                                </form>

                                {{-- Tombol Tolak untuk SuperAdmin --}}
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal-{{ $activity->id }}">
                                    Tolak
                                </button>

                                {{-- Modal Alasan Penolakan --}}
                                <div class="modal fade" id="rejectModal-{{ $activity->id }}" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form method="POST" action="{{ route('activities.reject', $activity->id) }}">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="rejectModalLabel">Alasan Penolakan</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <textarea name="rejection_reason" class="form-control" rows="3" placeholder="Masukkan alasan penolakan" required></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-danger">Tolak</button>
                                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @elseif (auth()->user()->hasRole('Admin') && $activity->status === 'pending_approval')
                                {{-- Tombol Edit untuk Admin jika status pending --}}
                                <a href="{{ route('activities.edit', $activity->id)}}" class="btn btn-success btn-sm">Edit</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            <div class="alert alert-danger">
                                Data Aktivitas belum tersedia.
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
</x-app-layout>
