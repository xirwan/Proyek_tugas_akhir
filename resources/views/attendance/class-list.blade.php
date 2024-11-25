<x-app-layout>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <x-card>
        <x-slot name="header">
            List Kelas Sekolah Minggu
        </x-slot>
        <table class="table table-responsive-md mb-0">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Absensi</th>
                    <th>Scan QR</th>
                </tr>
            </thead>
            <tbody>
                @forelse($classes as $index => $class)
                    <tr>
                        <td>{{ $classes->firstItem() + $index }}</td>
                        <td>{{ $class->name }}</td>
                        <td>{{ $class->description }}</td>
                        <td>{{ $class->status }}</td>
                        <td class="text-center">
                            @if($class->isActiveSchedule)
                                <a href="{{ route('attendance.classAttendance', $class->id) }}" class="btn btn-primary">
                                    Lihat Absensi
                                </a>
                            @else
                                <span class="text-muted">Jadwal Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($class->isActiveSchedule)
                                <a href="{{ route('attendance.showCheckinQr', $class->id) }}" class="btn btn-primary">
                                    Scan QR
                                </a>
                            @else
                                <span class="text-muted">Jadwal Tidak Aktif</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="p-3 mb-2 bg-danger text-white">
                                Data kelas sekolah minggu belum tersedia.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-5">
            {{ $classes->links() }}
        </div>
    </x-card>
</x-app-layout>