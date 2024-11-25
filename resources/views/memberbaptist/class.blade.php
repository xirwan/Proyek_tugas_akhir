<x-user>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <x-card>
        <x-slot name="header">
            Detail Kelas Pembaptisan
        </x-slot>

        <div>
            <p><strong>Kelas Baptis:</strong> {{ $class->day }}, {{ $class->start }} - {{ $class->end }} (Tanggal Baptis: {{ $class->baptist->date }})</p>
            <p><strong>Jumlah Pertemuan:</strong> {{ $details->total() }}</p>
        </div>

        <table class="table table-responsive-md mb-0">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Status Kehadiran</th>
                </tr>
            </thead>
            <tbody>
                @forelse($details as $index => $detail)
                    <tr class="text-center">
                        <td>{{ $details->firstItem() + $index }}</td>
                        <td>{{ $detail->date }}</td>
                        <td>
                            @if ($detail->date > $today)
                                Belum Dimulai
                            @else
                                {{ $attendance[$detail->id] ?? 'Tidak Hadir' }}
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
</x-user>