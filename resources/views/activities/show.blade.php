<x-app-layout>
    <x-card>
        <x-slot name="header">
            Detail Aktivitas: {{ $activity->title }}
        </x-slot>
        @if ($activity->status === 'rejected')
            <div class="alert alert-danger">
                <strong>Alasan Penolakan:</strong> {{ $activity->rejection_reason }}
            </div>
        @endif
        <div class="mb-3">
            <strong>Judul:</strong> {{ $activity->title }}
        </div>
        <div class="mb-3">
            <strong>Deskripsi:</strong> {{ $activity->description ?? '-' }}
        </div>
        <div class="mb-3">
            <strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $activity->status)) }}
        </div>
        <div class="mb-3">
            <strong>Jumlah Peserta:</strong> {{ $activity->max_participants }}
        </div>
        <div class="mb-3">
            <strong>Tanggal Kegiatan:</strong> {{ $activity->start_date }}
        </div>
        <div class="mb-3">
            <strong>Tanggal Pendaftaran:</strong> {{ $activity->registration_open_date }} Hingga {{ $activity->registration_close_date }}
        </div>
        <div class="mb-3">
            <strong>Batas Pembayaran:</strong> {{ $activity->payment_deadline ?? 'Tidak Ada' }}
        </div>
        <div class="mb-3">
            <strong>Biaya:</strong> {{ $activity->is_paid ? 'Rp' . number_format($activity->price, 0, ',', '.') : 'Gratis' }}
        </div>
        <div class="mb-3">
            <strong>Proposal Kegiatan:</strong>
            @if ($activity->proposal_file)
                <a href="{{ asset('storage/' . $activity->proposal_file) }}" target="_blank" class="btn btn-primary btn-sm">Lihat Proposal Kegiatan</a>
            @else
                Tidak ada file proposal kegiatan
            @endif
        </div>
        <div class="mb-3">
            <strong>Poster Kegiatan:</strong>
            @if ($activity->poster_file)
                <a href="{{ asset('storage/' . $activity->poster_file) }}" target="_blank" class="btn btn-primary btn-sm">Lihat Poster Kegiatan</a>
            @else
                Tidak ada file poster kegiatan
            @endif
        </div>
        <a href="{{ route('activities.index') }}" class="btn btn-success">Kembali</a>
    </x-card>
</x-app-layout>
