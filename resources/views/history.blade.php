<x-user>
    <x-card>
        <x-slot name="header">
            Riwayat Absensi
        </x-slot>

        <div class="table-responsive">
            <h3 class="mt-4">Riwayat Absensi Anda</h3>
            @if (count($attendanceRecords) > 0)
                <table class="table mb-0 text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Check-in</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attendanceRecords as $index => $record)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($record->scanned_at)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($record->scanned_at)->format('H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="mt-3">Tidak ada data absensi Anda.</p>
            @endif
        </div>
    </x-card>
</x-user>