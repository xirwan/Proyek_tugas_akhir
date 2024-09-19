<x-app-layout>
    <x-card>
        <x-slot name="header">
            List Anggota
        </x-slot>
        
        <a href= "{{ route('anggota.create') }}" class="btn btn-md btn-success mb-3">Tambah Anggota</a>

        <table class="table table-responsive-md mb-0">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama depan</th>
                    <th>Nama belakang</th>
                    <th>Tanggal lahir</th>
                    <th>Cabang</th>
                    <th>Role</th>
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
                        <td>{{ $itemanggota->cabang->nama }}</td>
                        <td>{{ $itemanggota->role->name }}</td>
                        <td>{{ $itemanggota->status }}</td>
                        <td>{{ $itemanggota->deskripsi }}</td>
                        <td class="actions text-center">
                            <a href="#"><i class="el el-info-circle"></i></a>
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