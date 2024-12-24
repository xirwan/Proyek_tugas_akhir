<x-app-layout>
    <style>
        .badge-custom {
            font-size: 0.95rem;
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
            Absensi Kelas Pembaptisan - Tanggal: {{ $classDetail->date }}
        </x-slot>

        <form action="{{ route('baptist-class-detail.markAttendance', encrypt($classDetail->id)) }}" method="POST">
            @csrf
            <table class="table table-responsive-md mb-0 text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peserta</th>
                        <th>Status Kehadiran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classDetail->memberBaptists as $index => $memberBaptist)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $memberBaptist->member->firstname }} {{ $memberBaptist->member->lastname }}</td>
                            <td>
                                @php
                                    $attendanceStatus = $classDetail->attendances->firstWhere('id_member', $memberBaptist->member->id);
                                @endphp
                                @if ($attendanceStatus)
                                    {{-- Sudah diabsen --}}
                                    <span class="badge badge-success badge-custom">Sudah Hadir</span>
                                @else
                                    {{-- Checkbox untuk absensi --}}
                                    <input type="checkbox" name="attendance[{{ $memberBaptist->member->id }}]" value="Hadir" class="form-check-input">
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">
                                <div class="alert alert-danger">
                                    Tidak ada peserta di kelas ini.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4 text-right">
                <button type="submit" class="btn btn-primary">Simpan Absensi</button>
                <a href="{{ route ('baptist.index') }}" class="btn btn-success">Kembali</a>
            </div>
        </form>
    </x-card>
</x-app-layout>