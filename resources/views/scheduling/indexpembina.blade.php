<x-app-layout>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <x-card>
        <x-slot name="header">
            Jadwal Saya
        </x-slot>

        {{-- Filter Form --}}
        <form method="GET" action="{{ route('myschedule.index') }}" class="mb-4">
            <div class="row">
                <div class="col-lg-3">
                    <select name="month" class="form-control">
                        <option value="">Pilih Bulan</option>
                        @foreach($months as $m)
                            <option value="{{ $m }}" {{ request('month') === $m ? 'selected' : '' }}>{{ $m }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('myschedule.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>

        {{-- Tabel Data --}}
        <table class="table table-responsive-md mb-0 text-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Bulan</th>
                    <th>Tahun</th>
                    <th>Tanggal</th>
                    <th>Hari</th>
                    <th>Jam</th>
                    <th>Kelas</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schedules as $index => $schedule)
                    <tr>
                        <td class="text-center">{{ $loop->iteration + $schedules->firstItem() - 1 }}</td>
                        <td>{{ $schedule->monthlySchedule->month }}</td>
                        <td>{{ $schedule->monthlySchedule->year }}</td>
                        <td>{{ $schedule->schedule_date }}</td>
                        <td>{{ $schedule->scheduleSundaySchoolClass->schedule->day ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($schedule->scheduleSundaySchoolClass->schedule->start)->format('H:i') ?? '-' }}</td>
                        <td>{{ $schedule->scheduleSundaySchoolClass->sundaySchoolClass->name ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            <div class="alert alert-danger">
                                Data Jadwal belum tersedia.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Navigasi Pagination --}}
        <div class="mt-5">
            {{ $schedules->links() }}
        </div>
    </x-card>
</x-app-layout>
