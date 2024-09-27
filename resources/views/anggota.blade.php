<x-app-layout>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <x-card>
        <x-slot name="header">
            List Anggota
        </x-slot>
        
        <a href= "{{ route('anggota.create') }}" class="btn btn-md btn-success mb-3">Tambah Anggota</a>

        <table class="table table-responsive mb-0">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama depan</th>
                    <th>Nama belakang</th>
                    <th>Tanggal lahir</th>
                    <th>Email</th>
                    <th>Cabang</th>
                    <th>Role</th>
                    <th>Posisi</th>
                    <th>Status</th>
                    <th>Deskripsi</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($anggota as $index => $itemanggota)
                    <tr>
                        <td>{{ $anggota->firstItem() + $index }}</td>
                        <td>{{ $itemanggota->nama_depan }}</td>
                        <td>{{ $itemanggota->nama_belakang }}</td>
                        <td>{{ $itemanggota->tanggal_lahir }}</td>
                        <td>{{ $itemanggota->user->email }}</td>
                        <td>{{ $itemanggota->cabang->nama }}</td>
                        <td>{{ $itemanggota->role->name }}</td>
                        <td>{{ $itemanggota->position->nama }}</td>
                        <td>{{ $itemanggota->status }}</td>
                        <td>{{ $itemanggota->deskripsi }}</td>
                        <td class="actions text-center">
                            <a href="{{ route('anggota.show', encrypt($itemanggota->id)) }}"><i class="el el-info-circle"></i></a>
                        </td>
                    </tr>
                @empty
                <div class="alert alert-danger">
                    Data Anggota belum tersedia.
                </div>
                @endforelse
            </tbody>
        </table>
        <div class="mt-5">
            {{ $anggota->links() }}
        </div>
    </x-card>   
</x-app-layout>