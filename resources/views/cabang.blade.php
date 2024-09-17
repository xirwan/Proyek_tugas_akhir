<x-app-layout>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <x-card>
        <x-slot name="header">
            List Cabang
        </x-slot>
        
        <a href="{{ route('cabang.create') }}" class="btn btn-md btn-success mb-3">Tambah Cabang</a>

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
                @forelse($cabangs as $index => $cabang)
                    <tr>
                        <td>{{ $cabangs->firstItem() + $index }}</td>
                        <td>{{ $cabang->nama }}</td>
                        <td>{{ $cabang->deskripsi }}</td>
                        <td>{{ $cabang->status }}</td>
                        <td class="actions text-center">
                            <a href="{{ route('cabang.show', encrypt($cabang->id)) }}"><i class="el el-info-circle"></i></a>
                        </td>
                    </tr>
                @empty
                <div class="alert alert-danger">
                    Data Cabang belum tersedia.
                </div>
                @endforelse
            </tbody>
        </table>
        <div class="mt-5">
            {{ $cabangs->links() }}
        </div>
    </x-card>
</x-app-layout>