<x-app-layout>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <x-card>
        <x-slot name="header">
            List Kelas Pembaptisan
        </x-slot>
        
        <a href="{{ route('baptist-classes.create') }}" class="btn btn-md btn-success mb-3">Tambah Kelas Pembaptisan</a>

        <table class="table table-responsive-md mb-0 text-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Baptis</th>
                    <th>Hari</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Detail</th>
                    <th>Jumlah Pertemuan</th>
                    <th>Jumlah Peserta</th>
                </tr>
            </thead>
            <tbody>
                @forelse($classes as $index => $class)
                    <tr>
                        <td>{{ $classes->firstItem() + $index }}</td>
                        <td>{{ $class->baptist->date }}</td>
                        <td>{{ $class->day }}</td>
                        <td>{{ $class->start }}</td>
                        <td>{{ $class->end }}</td>
                        <td>{{ $class->description }}</td>
                        <td>{{ $class->status }}</td>
                        <td>
                            @if($class->details->count() > 0)
                                <a href="{{ route('baptist-class-detail.index', encrypt($class->id)) }}" class="btn btn-success w-50">{{ $class->details->count() }}</a>
                            @else
                                <a href="{{ route('baptist-class-detail.create', encrypt($class->id)) }}" class="btn btn-sm btn-primary">
                                    Buat pertemuan
                                </a>
                            @endif
                        </td>
                        <td>
                            {{-- {{ $class->members->count() }} --}}
                            @if($class->members->count() > 0)
                                <a href="{{ route ('baptist-classes.viewClassMembers', encrypt($class->id)) }}" class="btn btn-success w-50">{{ $class->members->count() }}</a>
                            @else
                                    <p class="text-danger">Belum ada perserta</p>
                            @endif
                        </td>
                        <td class="actions text-center">
                            <a href="{{ route('baptist-classes.show', encrypt($class->id)) }}"><i class="el el-info-circle"></i></a>
                        </td>
                    </tr>
                @empty
                    <div class="alert alert-danger">
                        Data Kelas Pembaptisan belum tersedia.
                    </div>
                @endforelse
            </tbody>
        </table>
        <div class="mt-5">
            {{ $classes->links() }}
        </div>
    </x-card>
</x-app-layout>