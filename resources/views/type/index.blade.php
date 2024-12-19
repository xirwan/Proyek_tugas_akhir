<x-app-layout>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <x-card>
        <x-slot name="header">
            List Tipe Jadwal
        </x-slot>
        
        <a href="{{ route('type.create') }}" class="btn btn-md btn-success mb-3">Tambah Tipe Jadwal</a>
        <form method="GET" action="{{ route('type.index') }}" class="mb-4">
            <div class="row">
                <div class="col-lg-4">
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-lg-4">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('type.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
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
                @forelse($types as $index => $type)
                    <tr>
                        <td>{{ $types->firstItem() + $index }}</td>
                        <td>{{ $type->name }}</td>
                        <td>{{ $type->description }}</td>
                        <td class="text-center">{{ $type->status }}</td>
                        <td class="actions text-center">
                            <a href="{{ route('type.show', encrypt($type->id)) }}"><i class="el el-info-circle"></i></a>
                        </td>
                    </tr>
                @empty
                <div class="alert alert-danger">
                    Data Tipe Jadwal belum tersedia.
                </div>
                @endforelse
            </tbody>
        </table>
        <div class="mt-5">
            {{ $types->links() }}
        </div>
    </x-card>
</x-app-layout>