<x-app-layout>
    <style>
        .badge-custom {
            font-size: 0.95rem;
            font-weight: bold;
        }
    </style>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <x-card>
        <x-slot name="header">
            List Jadwal Pembaptisan
        </x-slot>
        
        <!-- Tombol untuk menambah jadwal pembaptisan -->
        <a href="{{ route('baptist.create') }}" class="btn btn-md btn-success mb-3">Tambah Jadwal Pembaptisan</a>

        <table class="table table-responsive-md mb-0 text-center">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($baptists as $index => $baptist)
                    <tr>
                        <td>{{ $baptists->firstItem() + $index }}</td>
                        <td>{{ $baptist->date }}</td>
                        <td>{{ $baptist->description ?? 'Tidak ada deskripsi' }}</td>
                        <td>
                            @if ($baptist->status === 'Active')
                                <span class="badge badge-success badge-custom text-white">Aktif</span>
                            @else
                                <span class="badge badge-danger badge-custom text-white">Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <!-- Tombol untuk melihat detail jadwal -->
                            <a href="{{ route('baptist.show', encrypt($baptist->id)) }}" class="btn btn-success btn-sm">
                                Detail
                            </a>
                            
                            <!-- Tombol untuk membuat pertemuan -->
                            <a href="{{ route('baptist-class-detail.create', encrypt($baptist->id)) }}" class="btn btn-primary btn-sm">
                                Buat Pertemuan
                            </a>
                            
                            <!-- Tombol untuk melihat daftar pertemuan -->
                            <a href="{{ route('baptist-class-detail.index', encrypt($baptist->id)) }}" class="btn btn-info btn-sm">
                                List Pertemuan
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-danger">Data Jadwal Pembaptisan belum tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-5">
            {{ $baptists->links() }}
        </div>
    </x-card>
</x-app-layout>