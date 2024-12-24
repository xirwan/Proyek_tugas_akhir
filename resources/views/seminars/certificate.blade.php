<x-user>
    <x-card>
        <x-slot name="header">
            Sertifikat Seminar Saya
        </x-slot>
        <table class="table table-responsive-md mb-0 text-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Seminar</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($seminarRegistrations as $index => $registration)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $registration->seminar->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($registration->seminar->event_date)->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('download.certificateseminar', $registration->id) }}" target="_blank" class="btn btn-success">
                                Lihat Sertifikat
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada sertifikat seminar tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </x-card>
</x-user>