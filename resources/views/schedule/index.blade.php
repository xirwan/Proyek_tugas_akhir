<x-app-layout>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <x-card>
        <x-slot name="header">
            List Jadwal
        </x-slot>

        <a href="{{ route('schedule.create') }}" class="btn btn-md btn-success mb-3">Tambah Jadwal</a>

        <table class="table table-responsive-md mb-0">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Hari</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Tipe</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                    <th>Deskripsi</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schedules as $index => $schedule)
                    <tr>
                        <td>{{ $schedules->firstItem() + $index }}</td>
                        <td>{{ $schedule->day }}</td>
                        <td>{{ $schedule->name }}</td>
                        <td>{{ $schedule->category->name }}</td>
                        <td>{{ $schedule->type->name }}</td>
                        <td>{{ $schedule->start }}</td>
                        <td>{{ $schedule->end }}</td>
                        <td>{{ $schedule->description }}</td>
                        <td class="actions text-center">
                            <a href="{{ route('schedule.show', encrypt($schedule->id)) }}"><i class="el el-info-circle"></i></a>
                        </td>
                    </tr>
                @empty
                    <div class="p-3 mb-2 bg-danger text-white">
                        Data Jadwal belum tersedia.
                    </div>
                @endforelse
            </tbody>
        </table>
        <div class="mt-5">
            {{ $schedules->links() }}
        </div>
    </x-card>
</x-app-layout>