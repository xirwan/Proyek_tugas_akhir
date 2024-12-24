<x-app-layout>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <x-card>
        <x-slot name="header">
            List Detail Pertemuan Pembaptisan
        </x-slot>
        <table class="table table-responsive-md mb-0 text-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $today = now()->toDateString();
                    $currentTime = now()->format('H:i');
                @endphp

                @forelse($details as $index => $detail)
                    <tr>
                        <td>{{ $details->firstItem() + $index }}</td>
                        <td>{{ $detail->date }}</td>
                        <td>{{ $detail->description ?? 'Tidak ada deskripsi' }}</td>
                        <td>
                            {{-- Tampilkan tombol Absensi jika pertemuan sesuai tanggal dan waktu --}}
                            @if ($detail->date === $today && $currentTime >= '00:00')
                                <a href="{{ route('memberpembaptisan.list', encrypt($detail->id)) }}" class="btn btn-primary">Lihat Peserta</a>
                            @else
                                <span class="text-muted">Belum Waktu Absensi</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-danger">Data Pertemuan Pembaptisan belum tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <a href="{{ route ('generate.indexpembaptisan') }}" class="btn btn-success">Kembali</a>
    </x-card>
    <div class="mt-4">
        {{-- Pagination --}}
        {{ $details->links() }}
    </div>
</x-app-layout>