<x-app-layout>
    <style>
        .badge-custom {
            font-size: 0.80rem;
            font-weight: bold;
        }
    </style>
    <x-card>
        <x-slot name="header">
            Checklist Manual Absensi untuk Jadwal: {{ $schedule->name }}
        </x-slot>

        <!-- Tabel Member -->
        <form action="{{ route('attendance.manual.store', $schedule->id) }}" method="POST">
            @csrf
            <div class="table-responsive">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Member</th>
                            <th>Status</th>
                            <th>Checklist</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($members as $index => $member)
                            @php
                                // Periksa apakah member sudah absen minggu ini
                                $alreadyCheckedIn = $attendanceRecords->contains('member_id', $member->id);
                            @endphp
                            <tr>
                                <td>{{ $members->firstItem() + $index }}</td>
                                <td>{{ $member->firstname }} {{ $member->lastname }}</td>
                                <td>
                                    @if ($alreadyCheckedIn)
                                        <span class="badge bg-success badge-custom text-white">Sudah Absen</span>
                                    @else
                                        <span class="badge bg-danger badge-custom text-white">Belum Absen</span>
                                    @endif
                                </td>
                                <td>
                                    @if (!$alreadyCheckedIn)
                                        <input type="checkbox" name="member_ids[]" value="{{ $member->id }}">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $members->links() }}
            </div>

            <!-- Tombol Simpan -->
            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-primary">Simpan Checklist</button>
            </div>
        </form>
    </x-card>
</x-app-layout>