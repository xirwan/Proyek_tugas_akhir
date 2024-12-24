<x-user>
    <x-card>
        <x-slot name="header">
            Sertifikat Pembaptisan Saya
        </x-slot>
        <table class="table table-responsive-md mb-0 text-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Pembaptisan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($baptistAttendances as $index => $attendance)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($attendance->classDetail->baptist->date)->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('download.certificatepembaptisan', $attendance->id) }}" target="_blank" class="btn btn-success">
                                Lihat Sertifikat
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Tidak ada sertifikat pembaptisan tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </x-card>
</x-user>
