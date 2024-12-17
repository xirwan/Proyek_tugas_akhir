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
    <x-card>
        <x-slot name="header">
            List Seminar
        </x-slot>

        <a href="{{ route('seminars.create') }}" class="btn btn-md btn-success mb-3">Tambah Seminar</a>

        <table class="table table-responsive-md mb-0">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Kuota Peserta</th>
                    <th>Poster</th>
                    <th>Tanggal Acara</th>
                    <th>Waktu</th>
                    <th>Pendaftaran Dibuka</th>
                    <th>Pendaftaran Ditutup</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($seminars as $index => $seminar)
                    <tr class="text-center">
                        <td>{{ $seminars->firstItem() + $index }}</td>
                        <td>{{ $seminar->name }}</td>
                        <td>{{ $seminar->description }}</td>
                        <td>
                            @if ($seminar->status === 'open') 
                            <span class="badge bg-success text-white badge-custom">Open</span>
                            @elseif ($seminar->status === 'closed') 
                                Close 
                            @else 
                                <span class="badge bg-warning text-white badge-custom">Selesai</span> 
                            @endif
                        </td>
                        <td>{{ $seminar->max_participants }}</td>
                        <td>
                            <!-- Tombol Lihat Poster -->
                            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#posterModal{{ $seminar->id }}">
                                Lihat Poster
                            </button>

                            <!-- Modal Poster -->
                            <div class="modal fade" id="posterModal{{ $seminar->id }}" tabindex="-1" role="dialog" aria-labelledby="posterModalLabel{{ $seminar->id }}">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="posterModalLabel{{ $seminar->id }}">Poster Seminar</h5>
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
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($seminar->event_date)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($seminar->start)->format('H:i')}}</td>
                        <td>{{ \Carbon\Carbon::parse($seminar->registration_start)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($seminar->registration_end)->format('d-m-Y') }}</td>
                        <td class="actions">
                            <a href="{{ route ('seminars.show', $seminar->id) }}"><i class="el el-info-circle"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">
                            <div class="alert alert-danger mb-0">
                                Data Seminar belum tersedia.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-5">
            {{ $seminars->links() }}
        </div>
    </x-card>
</x-app-layout>
