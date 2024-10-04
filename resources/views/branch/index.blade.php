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
        
        <a href="{{ route('branch.create') }}" class="btn btn-md btn-success mb-3">Tambah Cabang</a>

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
                @forelse($branches as $index => $branch)
                    <tr>
                        <td>{{ $branches->firstItem() + $index }}</td>
                        <td>{{ $branch->name }}</td>
                        <td>{{ $branch->address }}</td>
                        <td>{{ $branch->status }}</td>
                        <td class="actions text-center">
                            <a href="{{ route('branch.show', encrypt($branch->id)) }}"><i class="el el-info-circle"></i></a>
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
            {{ $branches->links() }}
        </div>
    </x-card>
</x-app-layout>