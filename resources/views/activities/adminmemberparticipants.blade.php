<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .badge-custom {
            font-size: 0.85rem;
            font-weight: bold;
        }
    </style>
    @if(session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <script>
        // Hilangkan notifikasi setelah 5 detik
        setTimeout(() => {
            const alert = document.getElementById('alert');
            if (alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }
        }, 5000);
    </script>

    <x-card>
        <x-slot name="header">
            Peserta Kegiatan: {{ $activity->title }}
        </x-slot>

        {{-- Tabel Data Peserta --}}
        <h5>Daftar Peserta</h5>
        <table class="table table-responsive-md mb-0 text-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Peserta</th>
                </tr>
            </thead>
            <tbody>
                @forelse($participants as $participant)
                    <tr>
                        <td>{{ $loop->iteration + $participants->firstItem() - 1 }}</td>
                        <td>{{ $participant->member->firstname }} {{ $participant->member->lastname }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">
                            <div class="alert alert-danger">
                                Belum ada peserta yang mendaftar.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $participants->appends(request()->except('participantsPage'))->links('pagination::bootstrap-5') }}
        </div>

        {{-- Tombol Kembali --}}
        <div class="mt-4 d-flex justify-content-end">
            <a href="{{ route('listactivities.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </x-card>
</x-app-layout>