<x-app-layout>
    @if (session('success'))
    <div id="alert" class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <x-card>
        <x-slot name="header">
            List Detail Pertemuan Kelas Pembaptisan
        </x-slot>
        
        <table class="table table-responsive-md mb-0">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($details as $index => $detail)
                    <tr class="text-center">
                        <td>{{ $details->firstItem() + $index }}</td>
                        <td>{{ $detail->date }}</td>
                        <td>
                            <a href="#" class="btn btn-success">Absensi</a>
                        </td>
                    </tr>
                @empty
                <div class="alert alert-danger">
                    Data Pertemuan Kelas Pembaptisan belum tersedia.
                </div>
                @endforelse
            </tbody>
        </table>
    </x-card>
    <div class="mt-4">
        {{ $details->links() }}
        <a href="{{ url()->previous() }}" class="btn btn-success">Kembali</a>
    </div>
</x-app-layout>