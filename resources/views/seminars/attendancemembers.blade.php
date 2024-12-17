<x-app-layout>
    <style>
        .badge-custom {
            font-size: 1.2rem;
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
            Absensi Peserta Seminar: {{ $seminar->name }}
        </x-slot>

        <form method="POST" action="{{ route('seminars.attendanceSave', $seminar->id) }}">
            @csrf
            <table class="table table-responsive-md mb-0">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Nama Depan</th>
                        <th>Nama Belakang</th>
                        <th>Hadir</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($seminar->registrations as $index => $registration)
                        <tr class="text-center">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $registration->member ? $registration->member->firstname : '-' }}</td>
                            <td>{{ $registration->member ? $registration->member->lastname : '-' }}</td>
                            <td>
                                @if ($registration->is_attended)
                                    <!-- Tetap kirimkan user_id yang sudah hadir -->
                                    <span class="badge bg-success badge-custom text-white">Hadir</span>
                                    <input type="hidden" name="attended_users[]" value="{{ $registration->user_id }}">
                                @else
                                    <input type="checkbox" name="attended_users[]" value="{{ $registration->user_id }}">
                                @endif
                            </td>                            
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada peserta yang mendaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="text-right mt-3">
                <button type="submit" class="btn btn-primary">Simpan Absensi</button>
                <a href="{{ route('seminars.indexAttendance') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </x-card>
</x-app-layout>    