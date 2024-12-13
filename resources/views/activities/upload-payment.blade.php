<x-user>
    <x-card>
        <x-slot name="header">
            Upload Bukti Pembayaran untuk Kegiatan: {{ $activity->title }}
        </x-slot>

        <form method="POST" action="#" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="payment_proof" class="form-label">Upload Bukti Pembayaran</label>
                <input type="file" name="payment_proof" id="payment_proof" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
            </div>

            <p class="text-muted">
                Total biaya: Rp{{ number_format($totalAmount, 0, ',', '.') }} ({{ $registeredChildrenCount }} anak).
            </p>

            <button type="submit" class="btn btn-primary">Upload Bukti</button>
            <a href="{{ route('activities.parent.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </x-card>
</x-user>