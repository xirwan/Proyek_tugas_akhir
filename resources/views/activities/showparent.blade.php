<x-user>
    <x-card>
        <x-slot name="header">
            Detail Kegiatan: {{ $activity->title }}
        </x-slot>

        <div class="row">
            {{-- Kolom Kiri --}}
            <div class="col-md-6">
                {{-- Informasi Kegiatan --}}
                <h5>Informasi Kegiatan</h5>
                <p><strong>Nama Kegiatan:</strong> {{ $activity->title }}</p>
                <p><strong>Tanggal Kegiatan:</strong> {{ $activity->start_date }}</p>
                <p><strong>Tanggal Pendaftaran Dibuka:</strong> {{ $activity->registration_open_date }}</p>
                <p><strong>Tanggal Pendaftaran Ditutup:</strong> {{ $activity->registration_close_date }}</p>
                @if ($activity->is_paid)
                    <p><strong>Biaya per Anak:</strong> Rp{{ number_format($activity->price, 0, ',', '.') }}</p>
                    <p><strong>Tanggal Deadline Pembayaran:</strong> {{ $activity->payment_deadline }}</p>
                @else
                    <p><strong>Biaya:</strong> Tidak Berbayar</p>
                @endif

                {{-- Poster --}}
                @if ($activity->poster_file)
                    <div class="mb-4">
                        <a href="{{ asset('storage/' . $activity->poster_file) }}" class="btn btn-info btn-sm" download>
                            Download Poster
                        </a>
                    </div>
                @endif
            </div>

            {{-- Kolom Kanan --}}
            <div class="col-md-6">
                {{-- Anak yang Didaftarkan --}}
                <h5>Anak yang Didaftarkan</h5>
                @if ($childrenRegistered)
                    <ul>
                        @foreach ($children as $child)
                            @if (in_array($child->id, $childrenRegistered))
                                <li>{{ $child->firstname }} {{ $child->lastname }}</li>
                            @endif
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">Belum ada anak yang didaftarkan.</p>
                @endif

                {{-- Status Pembayaran --}}
                @if ($activity->is_paid)
                    <h5>Status Pembayaran</h5>
                    @php
                        $payment = $activity->payments->where('parent_id', Auth::user()->member->id)->first();
                        $totalChildren = count($childrenRegistered);
                        $totalCost = $totalChildren * $activity->price;
                    @endphp

                    <p><strong>Total Anak yang Didaftarkan:</strong> {{ $totalChildren }}</p>
                    <p><strong>Total Biaya:</strong> Rp{{ number_format($totalCost, 0, ',', '.') }}</p>

                    @if (!$payment)
                        <p class="text-muted">Belum Upload Bukti Pembayaran</p>
                    @elseif ($payment->payment_status === 'Diproses')
                        <span class="badge bg-warning">Menunggu Verifikasi</span>
                    @elseif ($payment->payment_status === 'Berhasil')
                        <span class="badge bg-success">Terverifikasi</span>
                    @elseif ($payment->payment_status === 'Ditolak')
                        <span class="badge bg-danger">Ditolak</span>
                    @endif

                    {{-- Tombol Upload Bukti Pembayaran --}}
                    @if (!$payment || $payment->payment_status === 'Ditolak')
                        <form method="POST" action="{{ route('activities.upload.payment', $activity->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="payment_proof" class="form-label">Upload Bukti Pembayaran</label>
                                <input type="file" name="payment_proof" id="payment_proof" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                                <small class="text-muted">Total Pembayaran: Rp{{ number_format($totalCost, 0, ',', '.') }}</small>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Upload Bukti Pembayaran</button>
                            </div>
                        </form>
                    @endif
                @endif
            </div>
        </div>

        {{-- Tombol Kembali --}}
        <div class="mt-4 d-flex justify-content-end">
            <a href="{{ route('activities.parent.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </x-card>
</x-user>
