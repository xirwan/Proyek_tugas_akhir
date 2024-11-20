<x-user>
    <x-card>
        <x-slot name="header">
            Riwayat Absensi Anak
        </x-slot>
        <form method="GET" action="{{ route('attendance.parentView') }}">
            <div class="form-group">
                <label for="child_id">Pilih Anak</label>
                <select name="child_id" id="child_id" class="form-control">
                    <option value="">-- Pilih Anak --</option>
                    @foreach ($children as $child)
                        <option value="{{ $child->id }}" {{ $selectedChild && $selectedChild->id == $child->id ? 'selected' : '' }}>
                            {{ $child->firstname . ' ' . $child->lastname }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Tampilkan Absensi</button>
        </form>
        @if ($selectedChild)
        <h3 class="mt-4">Absensi untuk {{ $selectedChild->firstname . ' ' . $selectedChild->lastname }}</h3>
            @if (count($attendanceRecords) > 0)
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Minggu</th>
                            <th>Check-in</th>
                            <th>Kelas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attendanceRecords as $index => $record)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $record->week_of }}</td>
                                <td>{{ $record->check_in }}</td>
                                <td>{{ $record->member->sundaySchoolClasses->first()->name ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="mt-3">Tidak ada data absensi untuk anak ini.</p>
            @endif
        @endif
    </x-card>
</x-user>