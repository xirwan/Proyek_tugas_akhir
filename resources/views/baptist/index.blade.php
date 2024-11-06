<x-app-layout>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <x-card>
        <x-slot name="header">
            List Jadwal Pembaptisan
        </x-slot>
        
        <a href="{{ route('baptist.create') }}" class="btn btn-md btn-success mb-3">Tambah Jadwal Pembaptisan</a>

        <table class="table table-responsive-md mb-0">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($baptists as $index => $baptist)
                    <tr>
                        <td>{{ $baptists->firstItem() + $index }}</td>
                        <td>{{ $baptist->date }}</td>
                        <td>{{ $baptist->description }}</td>
                        <td>{{ $baptist->status }}</td>
                        <td class="actions text-center">
                            <a href="{{ route('baptist.show', encrypt($baptist->id)) }}"><i class="el el-info-circle"></i></a>
                        </td>
                    </tr>
                @empty
                <div class="alert alert-danger">
                    Data Jadwal Pembaptisan belum tersedia.
                </div>
                @endforelse
            </tbody>
        </table>
        <div class="mt-5">
            {{ $baptists->links() }}
        </div>
    </x-card>
</x-app-layout>