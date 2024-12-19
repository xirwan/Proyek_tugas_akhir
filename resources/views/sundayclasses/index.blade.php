<x-app-layout>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <x-card>
        <x-slot name="header">
            List Kelas Sekolah Minggu
        </x-slot>
        <a href="{{ route('sunday-classes.create') }}" class="btn btn-md btn-success mb-3">Tambah Kelas Sekolah Minggu</a>
        <form method="GET" action="{{ route('sunday-classes.index') }}" class="mb-4">
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
                    <a href="{{ route('sunday-classes.index') }}" class="btn btn-secondary">Reset</a>
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
                    <th>Jadwal</th>
                    <th>Detail Murid</th>
                    <th>Detail Kelas</th>
                </tr>
            </thead>
            <tbody>
                @forelse($classes as $index => $class)
                    <tr>
                        <td>{{ $classes->firstItem() + $index }}</td>
                        <td>{{ $class->name }}</td>
                        <td>{{ $class->description }}</td>
                        <td>{{ $class->status }}</td>
                        <td>
                            @foreach($class->schedules as $schedule)
                                <p>{{ $schedule->name }} ({{ ucfirst($schedule->day) }}: {{ \Carbon\Carbon::parse($schedule->start)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end)->format('H:i') }})</p>
                            @endforeach
                        </td>
                        <td class="actions text-center">
                            <a href="{{ route('sundayschoolclass.viewClassStudents', encrypt($class->id)) }}"><i class="el el-info-circle"></i></a>
                        </td>
                        <td class="actions text-center">
                            <a href="{{ route('sunday-classes.show', encrypt($class->id)) }}"><i class="el el-info-circle"></i></a>
                        </td>
                    </tr>
                @empty
                    <div class="alert alert-danger">
                        Data kelas sekolah minggu belum tersedia.
                    </div>
                @endforelse
            </tbody>
        </table>
        <div class="mt-5">
            {{ $classes->links() }}
        </div>
    </x-card>
</x-app-layout>