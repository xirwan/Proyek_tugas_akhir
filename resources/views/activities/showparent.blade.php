<x-user>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Notifikasi Error -->
    @if ($errors->any())
        <div id="alert" class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .badge-custom {
            font-size: 1.2rem;
            font-weight: bold;
        }
    </style>
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
                        <a href="{{ asset('storage/' . $activity->poster_file) }}" class="btn btn-primary btn-sm" download>
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
                @if ($activity->is_paid && !empty($childrenRegistered))
                    
                    @php
                        $payment = $activity->payments->where('parent_id', Auth::user()->member->id)->first();
                        $totalChildren = count($childrenRegistered);
                        $totalCost = $totalChildren * $activity->price;
                    @endphp

                    <p><strong>Total Anak yang Didaftarkan:</strong> {{ $totalChildren }}</p>
                    <p><strong>Total Biaya:</strong> Rp{{ number_format($totalCost, 0, ',', '.') }}</p>
                    <h5>Status Pembayaran</h5>
                    @if (!$payment)
                        <p class="text-muted">Belum Upload Bukti Pembayaran</p>
                    @elseif ($payment->payment_status === 'Diproses')
                        <span class="badge bg-warning badge-custom">Menunggu Verifikasi</span>
                    @elseif ($payment->payment_status === 'Berhasil')
                        <span class="badge bg-success text-white badge-custom">Terverifikasi</span>
                    @elseif ($payment->payment_status === 'Ditolak')
                        <span class="badge bg-danger text-white badge-custom">Ditolak</span>
                    @endif

                    {{-- Tombol untuk melihat bukti pembayaran --}}
                    @if ($payment && $payment->payment_proof)
                        <div class="mt-2">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#paymentModal">
                                Lihat Bukti Pembayaran
                            </button>
                        </div>

                        {{-- Modal Bukti Pembayaran --}}
                        <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="paymentModalLabel">Bukti Pembayaran</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="{{ asset('storage/' . $payment->payment_proof) }}" class="img-fluid" alt="Bukti Pembayaran">
                                    </div>
                                    <div class="modal-footer justify-content-end">
                                        <a href="{{ asset('storage/' . $payment->payment_proof) }}" class="btn btn-primary" download>Unduh Bukti</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Tombol Upload Bukti Pembayaran --}}
                    @if (!$payment || $payment->payment_status === 'Ditolak' || $payment->payment_status === 'Diproses')
                        <form method="POST" action="{{ route('activities.upload.payment', $activity->id) }}" enctype="multipart/form-data" class="mt-3">
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
