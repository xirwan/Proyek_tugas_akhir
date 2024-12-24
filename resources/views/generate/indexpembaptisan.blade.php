<x-app-layout>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <x-card>
        <x-slot name="header">
            List Sertifikasi Pembaptisan
        </x-slot>
        
        <table class="table table-responsive-md mb-0 text-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Deskripsi</th>
                    <th>Tanggal Acara</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($baptists as $index => $baptist)
                    <tr>
                        <td>{{ $baptists->firstItem() + $index }}</td>
                        <td>{{ $baptist->description ?? 'Tidak ada deskripsi' }}</td>
                        <td>{{ $baptist->date }}</td>
                        <td>
                            <a href="{{ route('generate.indexpembaptisandetail', encrypt($baptist->id)) }}" class="btn btn-primary">
                                List Pertemuan
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">
                            <div class="alert alert-danger mb-0">
                                Data Pembaptisan belum tersedia.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $baptists->links() }}
        </div>
    </x-card>
</x-app-layout>