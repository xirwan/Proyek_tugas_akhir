<x-app-layout>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <x-card>
        <x-slot name="header">
            List Posisi
        </x-slot>

        <a href="{{ route('position.create') }}" class="btn btn-md btn-success mb-3">Tambah Posisi</a>

        <table class="table table-responsive-md mb-0">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($positions as $index => $position)
                    <tr>
                        <td>{{ $positions->firstItem() + $index }}</td>
                        <td>{{ $position->name }}</td>
                        <td>{{ $position->description }}</td>
                        <td>{{ $position->status }}</td>
                        <td class="actions text-center">
                            <a href="{{ route('position.show', encrypt($position->id)) }}"><i class="el el-info-circle"></i></a>
                        </td>
                    </tr>
                @empty
                <div class="alert alert-danger">
                    Data Posisi belum tersedia.
                </div>
                @endforelse
            </tbody>
        </table>
        <div class="mt-5">
            {{ $positions->links() }}
        </div>
    </x-card>
</x-app-layout>