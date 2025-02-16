<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .badge-custom {
            font-size: 0.85rem; /* Atur ukuran sesuai keinginan */
            font-weight: bold; /* Opsional: membuat teks lebih tebal */
        }
    </style>
    @if(session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
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

        <form method="GET" action="{{ route('activities.participants.view', $activity->id) }}" class="mb-3">
            <div class="row">
                <div class="col-lg-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari Nama Anak atau Orang Tua" value="{{ request('search') }}">
                </div>
                <div class="col-lg-4">
                    <select name="payment_status" class="form-control">
                        <option value="">Semua Status Pembayaran</option>
                        <option value="Berhasil" {{ request('payment_status') === 'Berhasil' ? 'selected' : '' }}>Terverifikasi</option>
                        <option value="Diproses" {{ request('payment_status') === 'Diproses' ? 'selected' : '' }}>Belum Diverifikasi</option>
                        <option value="Ditolak" {{ request('payment_status') === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                
                <div class="col-lg-4">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('activities.participants.view', $activity->id) }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>

        {{-- Tabel Data Peserta --}}
        <h5>Daftar Peserta</h5>
        <table class="table table-responsive-md mb-0 text-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Anak</th>
                    <th>Nama Orang Tua</th>
                    @if ($activity->is_paid)
                        <th>Status Pembayaran</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($participants as $participant)
                    <tr>
                        <td>{{ $loop->iteration + $participants->firstItem() - 1 }}</td>
                        <td>{{ $participant->child->firstname }} {{ $participant->child->lastname }}</td>
                        <td>
                            @if ($participant->parent)
                                {{ $participant->parent->firstname }} {{ $participant->parent->lastname }}
                            @else
                                <span class="text-danger">Orang tua tidak ditemukan</span>
                            @endif
                        </td>
                        @if ($activity->is_paid)
                            <td>
                                @if ($participant->payment && $participant->payment->activity_id == $activity->id)
                                    @if ($participant->payment->payment_status === 'Berhasil')
                                        <span class="badge bg-success text-white badge-custom">Terverifikasi</span>
                                    @elseif ($participant->payment->payment_status === 'Diproses')
                                        <span class="badge bg-warning badge-custom">Belum Diverifikasi</span>
                                    @elseif ($participant->payment->payment_status === 'Ditolak')
                                        <span class="badge bg-danger text-white badge-custom">Ditolak</span>
                                    @endif
                                @else
                                    <span class="badge bg-warning badge-custom">Belum Ada Pembayaran</span>
                                @endif
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $activity->is_paid ? 4 : 3 }}" class="text-center">
                            <div class="alert alert-danger">
                                Belum ada peserta yang mendaftar.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{-- Pagination Peserta --}}
        <div class="mt-4">
            {{ $participants->appends(request()->except('participantsPage'))->links('pagination::bootstrap-5') }}
        </div>

        {{-- Tabel Pembayaran --}}
        @if ($activity->is_paid)
            <h5 class="mt-4">Daftar Pembayaran</h5>
            <table class="table table-responsive-md mb-0 text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Orang Tua</th>
                        <th>Total Anak</th>
                        <th>Total Pembayaran</th>
                        <th>Status Pembayaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td>{{ $loop->iteration + $payments->firstItem() - 1 }}</td>
                            <td>
                                @if ($payment->parent)
                                    {{ $payment->parent->firstname }} {{ $payment->parent->lastname }}
                                @else
                                    <span class="text-danger">Orang tua tidak ditemukan</span>
                                @endif
                            </td>
                            <td>{{ $payment->total_children }}</td>
                            <td>Rp{{ number_format($payment->total_amount, 0, ',', '.') }}</td>
                            <td>
                                @if ($payment->payment_status === 'Berhasil')
                                    <span class="badge bg-success text-white badge-custom">Terverifikasi</span>
                                @elseif ($payment->payment_status === 'Diproses')
                                    <span class="badge bg-warning badge-custom">Belum Diverifikasi</span>
                                @elseif ($payment->payment_status === 'Ditolak')
                                    <span class="badge bg-danger text-white badge-custom">Ditolak</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Diketahui</span>
                                @endif
                            </td>
                            <td>
                                {{-- Tombol untuk melihat bukti pembayaran --}}
                                @if ($payment->payment_proof)
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#paymentModal-{{ $payment->id }}">
                                        Lihat Bukti
                                    </button>

                                    {{-- Modal Bukti Pembayaran --}}
                                    <div class="modal fade" id="paymentModal-{{ $payment->id }}" tabindex="-1" aria-labelledby="paymentModalLabel-{{ $payment->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="paymentModalLabel-{{ $payment->id }}">Bukti Pembayaran</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <img src="{{ asset('storage/' . $payment->payment_proof) }}" class="img-fluid" alt="Bukti Pembayaran">
                                                </div>
                                                <div class="modal-footer justify-content-end">
                                                    <a href="{{ asset('storage/' . $payment->payment_proof) }}" class="btn btn-primary" download>Download Bukti</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">Tidak Ada Bukti</span>
                                @endif

                                {{-- Tombol Verifikasi dan Tolak --}}
                                @if ($payment->payment_status !== 'Berhasil')
                                    <form method="POST" action="{{ route('activities.payment.verify', $activity->id) }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="parent_id" value="{{ $payment->parent_id }}">
                                        <button type="submit" class="btn btn-success btn-sm">Verifikasi</button>
                                    </form>
                                    <form method="POST" action="{{ route('activities.payment.reject', $activity->id) }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="parent_id" value="{{ $payment->parent_id }}">
                                        <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                <div class="alert alert-danger">
                                    Belum ada pembayaran.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{-- Pagination Pembayaran --}}
            <div class="mt-4">
                {{ $payments->appends(request()->except('paymentsPage'))->links('pagination::bootstrap-5') }}
            </div>
        @endif

        {{-- Tombol Kembali --}}
        <div class="mt-4 d-flex justify-content-end">
            <a href="{{ route('listactivities.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </x-card>
</x-app-layout>
{{-- form kalau pake midtrans --}}
{{-- <x-app-layout>
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
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <script>
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
        <h5>Daftar Peserta</h5>
        <table class="table table-responsive-md mb-0 text-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Anak</th>
                    <th>Nama Orang Tua</th>
                    @if ($activity->is_paid)
                        <th>Status Pembayaran</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($participants as $participant)
                    <tr>
                        <td>{{ $loop->iteration + $participants->firstItem() - 1 }}</td>
                        <td>{{ $participant->child->firstname }} {{ $participant->child->lastname }}</td>
                        <td>
                            @if ($participant->parent)
                                {{ $participant->parent->firstname }} {{ $participant->parent->lastname }}
                            @else
                                <span class="text-danger">Orang tua tidak ditemukan</span>
                            @endif
                        </td>
                        @if ($activity->is_paid)
                            <td>
                                @if ($participant->payment && $participant->payment->activity_id == $activity->id)
                                    @if ($participant->payment->midtrans_transaction_status === 'settlement')
                                        <span class="badge bg-success text-white badge-custom">Terbayar</span>
                                    @elseif ($participant->payment->midtrans_transaction_status === 'pending')
                                        <span class="badge bg-warning text-white badge-custom">Belum dibayar</span>
                                    @endif
                                @else
                                    <span class="badge bg-warning badge-custom">Belum Ada Pembayaran</span>
                                @endif
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $activity->is_paid ? 4 : 3 }}" class="text-center">
                            <div class="alert alert-danger">
                                Belum ada peserta yang mendaftar.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $participants->appends(request()->except('participantsPage'))->links('pagination::bootstrap-5') }}
        </div>
        <div class="mt-4 d-flex justify-content-end">
            <a href="{{ route('listactivities.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </x-card>
</x-app-layout> --}}