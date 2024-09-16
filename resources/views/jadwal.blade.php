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

        <a href="{{ route('jadwal.create') }}" class="btn btn-md btn-success mb-3">Tambah Jadwal</a>

        <table class="table table-responsive-md mb-0">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Hari</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwal as $index => $itemjadwal)
                    <tr>
                        <td>{{ $jadwal->firstItem() + $index }}</td>
                        <td>{{ $itemjadwal->hari }}</td>
                        <td>{{ $itemjadwal->nama }}</td>
                        <td>{{ $itemjadwal->deskripsi }}</td>
                        <td class="actions text-center">
                            <a href="{{ route('jadwal.show', encrypt($itemjadwal->id)) }}"><i class="el el-info-circle"></i></a>
                        </td>
                    </tr>
                @empty
                <div class="alert alert-danger">
                    Data Jadwal belum tersedia.
                </div>
                @endforelse
            </tbody>
        </table>
        <div class="mt-5">
            {{ $jadwal->links() }}
        </div>
    </x-card>
</x-app-layout>