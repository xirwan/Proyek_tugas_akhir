<x-user>
    <style>
        .badge-custom {
            font-size: 1rem;
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
            Daftar Seminar Tersedia
        </x-slot>

        <table class="table table-responsive-md mb-0">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama Seminar</th>
                    <th>Deskripsi</th>
                    <th>Poster</th>
                    <th>Tanggal Acara</th>
                    <th>Jam</th>
                    <th>Pendaftaran Dibuka</th>
                    <th>Pendaftaran Ditutup</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($seminars as $index => $seminar)
                    @php
                        $isRegistrationOpen = now()->between($seminar->registration_start, $seminar->registration_end);
                        $currentParticipants = $seminar->registrations->count();
                        $isQuotaAvailable = $currentParticipants < $seminar->max_participants;

                        // Cek apakah user sudah mendaftar
                        $isUserRegistered = $seminar->registrations()
                            ->where('user_id', auth()->id())
                            ->exists();
                    @endphp

                    <tr class="text-center">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $seminar->name }}</td>
                        <td>{{ $seminar->description }}</td>
                        <td>
                            <!-- Tombol Lihat Poster -->
                            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#posterModal{{ $seminar->id }}">
                                Lihat Poster
                            </button>

                            <!-- Modal Popup Poster -->
                            <div class="modal fade" id="posterModal{{ $seminar->id }}" tabindex="-1" role="dialog" aria-labelledby="posterModalLabel{{ $seminar->id }}" aria-hidden="true">
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
                                            <a href="{{ asset('storage/' . $seminar->poster_file) }}" download class="btn btn-primary">Download Poster</a>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($seminar->event_date)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($seminar->start)->format('H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($seminar->registration_start)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($seminar->registration_end)->format('d-m-Y') }}</td>
                        <td>
                            @if ($isUserRegistered)
                                <span class="badge bg-success badge-custom text-white">Sudah Terdaftar</span>
                            @elseif ($isRegistrationOpen && $isQuotaAvailable)
                                <!-- Tombol Daftar Seminar -->
                                <form method="POST" action="{{ route('seminars.registermember', $seminar->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin mendaftar ke seminar ini?');">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Daftar</button>
                                </form>
                            @elseif (!$isQuotaAvailable)
                                <span class="badge bg-danger badge-custom text-white">Kuota Penuh</span>
                            @else
                                <span class="badge bg-secondary badge-custom text-white">Ditutup</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center">
                            <div class="alert alert-danger mb-0">Belum ada seminar yang tersedia saat ini.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </x-card>
</x-user>