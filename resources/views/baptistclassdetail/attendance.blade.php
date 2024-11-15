<x-app-layout>
    <x-card>
        <x-slot name="header">
            Absensi Kelas Pembaptisan - Tanggal: {{ $classDetail->date }}
        </x-slot>

        {{-- Encrypt ID untuk dikirimkan ke route --}}
        <form action="{{ route('baptist-class-detail.markAttendance', encrypt($classDetail->id)) }}" method="POST">
            @csrf
            <table class="table table-responsive-md mb-0">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Nama Peserta</th>
                        <th>Status Kehadiran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classDetail->baptistClass->members as $index => $memberBaptist)
                        <tr class="text-center">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $memberBaptist->member->firstname }} {{ $memberBaptist->member->lastname }}</td>
                            <td>
                                <select name="attendance[{{ $memberBaptist->member->id }}]" class="form-control">
                                    <option value="Hadir" {{ old("attendance.{$memberBaptist->member->id}") == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                    <option value="Tidak Hadir" {{ old("attendance.{$memberBaptist->member->id}") == 'Tidak Hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                                </select>
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
                <a href="{{ url()->previous() }}" class="btn btn-success">Kembali</a>
            </div>
        </form>
    </x-card>
</x-app-layout>