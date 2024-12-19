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

        <!-- Filter Form -->
        <form method="GET" action="{{ route('position.index') }}" class="mb-4">
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
                    <a href="{{ route('position.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>

        

        <!-- Table -->
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
                        <td class="text-center">{{ $position->status }}</td>
                        <td class="actions text-center">
                            <a href="{{ route('position.show', encrypt($position->id)) }}"><i class="el el-info-circle"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Data Posisi belum tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-5">
            {{ $positions->withQueryString()->links() }}
        </div>
    </x-card>
</x-app-layout>