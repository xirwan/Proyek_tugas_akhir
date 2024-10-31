<x-app-layout>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <x-card>
        <x-slot name="header">
            List Absensi {{ $class->name }}
        </x-slot>
        <form action="{{ route('attendance.manualCheckin', $class->id) }}" method="POST">
        @csrf
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Status Kehadiran</th>
                        <th>Checklist Manual</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $index => $student)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $student->firstname }} {{ $student->lastname }}</td>
                            <td>
                                @if (in_array($student->id, $presentStudentIds))
                                    ✔️ Hadir Minggu Ini
                                @else
                                    ❌ Tidak Hadir
                                @endif
                            </td>
                            <td>
                                @if (!in_array($student->id, $presentStudentIds))
                                    <input type="checkbox" name="manual_checkins[]" value="{{ $student->id }}">
                                @else
                                    ✔️ Sudah Hadir
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Simpan Checklist Manual</button>
        </form>
    </x-card>
</x-app-layout>