<x-app-layout>
    <x-card>
        <x-slot name="header">
            List Kegiatan
        </x-slot>

        {{-- Tabel Data --}}
        <table class="table table-responsive-md mb-0 text-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Tanggal Kegiatan</th>
                    <th>Total Peserta</th>
                    <th>Sisa Slot Peserta</th> {{-- Tambahkan Kolom Slot Peserta --}}
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activities as $activity)
                    <tr>
                        <td>{{ $loop->iteration + $activities->firstItem() - 1 }}</td>
                        <td>{{ $activity->title }}</td>
                        <td>{{ $activity->start_date }}</td>
                        <td>{{ $activity->registrations->count() }}</td>
                        <td>
                            @if ($activity->max_participants)
                                {{ $activity->max_participants - $activity->registrations->count() }}
                            @else
                                Tidak Ditentukan
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('activities.participants.view', $activity->id) }}" class="btn btn-primary btn-sm">
                                Lihat Peserta
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            <div class="alert alert-danger">
                                Belum ada kegiatan yang disetujui.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Navigasi Pagination --}}
        <div class="mt-4">
            {{ $activities->links() }}
        </div>
    </x-card>
</x-app-layout>
    