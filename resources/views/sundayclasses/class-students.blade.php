<x-app-layout>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <x-card>
        <x-slot name="header">
            Daftar Murid di {{ $class->name }}
        </x-slot>
        <form method="GET" action="{{ route('sundayschoolclass.viewClassStudents', ['encryptedId' => $encryptedClassId]) }}" class="mb-4">
            <div class="row">
                <div class="col-lg-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama anak" value="{{ request('search') }}">
                </div>
                <div class="col-lg-4">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('sundayschoolclass.viewClassStudents', ['encryptedId' => $encryptedClassId]) }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>        
        <table class="table table-responsive-md mb-0 text-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Tanggal Lahir</th>
                    <th>Alamat</th>
                    <th>Cabang</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $index => $student)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $student->firstname }} {{ $student->lastname }}</td>
                        <td>{{ $student->dateofbirth }}</td>
                        <td>{{ $student->address }}</td>
                        <td>{{ $student->branch->name ?? '-' }}</td>
                        <td>{{ $student->status }}</td>
                        <td>
                            <a href="{{ route('sundayschoolclass.showAdjustClassForm', encrypt($student->id)) }}" class="btn btn-sm btn-primary">
                                Sesuaikan Kelas
                            </a>
                        </td>
                    </tr>
                @empty
                    <div class="alert alert-danger">
                        Tidak ada murid yang terdaftar di kelas ini.
                    </div>
                @endforelse
            </tbody>
        </table>
        <div class="mt-5">
            {{ $students->links() }}
        </div>
        <a href="{{ route ('sunday-classes.index') }}" class="btn btn-success">Kembali</a>
    </x-card>
</x-app-layout>