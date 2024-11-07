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

        <table class="table table-responsive-md mb-0">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Tanggal Baptis</th>
                    <th>Hari</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Detail</th>
                    <th>Jumlah Pertemuan</th>
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
                        <td class="actions text-center">
                            <a href="{{ route('baptist-classes.show', encrypt($class->id)) }}"><i class="el el-info-circle"></i></a>
                        </td>
                        <td class="text-center">
                            @if($class->details->count() > 0)
                                <a href="{{ route('baptist-class-detail.index', encrypt($class->id)) }}" class="btn btn-success w-50">{{ $class->details->count() }}</a>
                            @else
                                <a href="{{ route('baptist-class-detail.create', encrypt($class->id)) }}" class="btn btn-primary">
                                    Buat pertemuan
                                </a>
                            @endif
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