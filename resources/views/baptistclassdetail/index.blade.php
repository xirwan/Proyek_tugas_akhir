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
                @php
                    $today = now()->toDateString();
                    $currentTime = now()->format('H:i');
                @endphp

                @forelse($details as $index => $detail)
                    <tr class="text-center">
                        <td>{{ $details->firstItem() + $index }}</td>
                        <td>{{ $detail->date }}</td>
                        <td>
                            {{-- Cek apakah tanggal pertemuan adalah hari ini dan jam sudah mencapai atau melebihi jam mulai --}}
                            @if ($detail->date === $today && $currentTime >= '00:00')
                                <a href="{{ route('baptist-class-detail.attendanceForm', encrypt($detail->id)) }}" class="btn btn-success">Absensi</a>
                            @else
                                <span class="text-muted">Belum Waktu Absensi</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">
                            <div class="p-3 mb-2 bg-danger text-white">
                                Data Pertemuan Kelas Pembaptisan belum tersedia.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </x-card>
    <div class="mt-4">
        {{ $details->links() }}
        <a href="{{ url()->previous() }}" class="btn btn-success">Kembali</a>
    </div>
</x-app-layout>
