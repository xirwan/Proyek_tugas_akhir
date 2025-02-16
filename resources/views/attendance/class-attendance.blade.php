<x-app-layout>
    <style>
        .badge-custom {
            font-size: 0.85rem;
            font-weight: bold;
        }
    </style>
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
            <table class="table text-center">
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
                                @php
                                    // Cek apakah siswa ada di tabel absensi minggu ini dan check_in-nya
                                    $attendance = $student->sundaySchoolPresence()->where('week_of', $weekOf)->first();
                                @endphp
                                
                                @if ($attendance && $attendance->check_in) 
                                    ✔️ Hadir Minggu Ini
                                @elseif ($attendance && !$attendance->check_in)
                                    ❌ Tidak Hadir
                                @else
                                    ❌ Tidak Hadir
                                @endif
                            </td>
                            <td>
                                @if (!$attendance || !$attendance->check_in)
                                    {{-- Tampilkan checkbox hanya jika murid belum hadir --}}
                                    <input type="checkbox" name="manual_checkins[]" value="{{ $student->id }}" class="manual-checkin-checkbox">
                                @else
                                    {{-- Jika murid sudah hadir, tampilkan teks atau badge --}}
                                    <span class="badge badge-success badge-custom text-white">Sudah Hadir</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary" onclick="return confirm('Apakah Anda yakin ingin dengan checklist absensi ini?');">Simpan Checklist Manual</button>
            <a href="{{ route ('attendance.classList') }}" class="btn btn-default">Kembali</a>
        </form>
    </x-card>
</x-app-layout>