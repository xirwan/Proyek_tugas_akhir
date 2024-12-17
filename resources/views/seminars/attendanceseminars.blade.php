<x-app-layout>
    <style>
        .badge-custom {
            font-size: 1.2rem;
            font-weight: bold;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <x-card>
        <x-slot name="header">
            List Peserta Seminar
        </x-slot>
        <table class="table table-responsive-md mb-0">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>                    
                    <th>Tanggal Acara</th>
                    <th>Waktu</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($seminars as $index => $seminar)
                    <tr class="text-center">
                        <td>{{ $seminars->firstItem() + $index }}</td>
                        <td>{{ $seminar->name }}</td>
                        <td>{{ $seminar->description }}</td>
                        <td>{{ \Carbon\Carbon::parse($seminar->event_date)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($seminar->start)->format('H:i')}}</td>
                        <td class="actions">
                            <a href="{{ route ('seminars.attendancelist', $seminar->id) }}"><button class="btn btn-primary">Detail Peserta</button></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">
                            <div class="alert alert-danger mb-0">
                                Data Seminar belum tersedia.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-5">
            {{ $seminars->links() }}
        </div>
    </x-card>
</x-app-layout>