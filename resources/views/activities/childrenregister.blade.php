<x-user>
    <x-card>
        <x-slot name="header">
            Pendaftaran Kegiatan: {{ $activity->title }}
        </x-slot>

        <form method="POST" action="{{ route('activities.register.children', $activity->id) }}" id="registration-form">
            @csrf
            <div class="mb-3">
                <label for="child_ids" class="form-label">Daftar Anak</label>
                <div class="form-check">
                    {{-- Tampilkan semua anak, baik yang sudah terdaftar maupun yang belum --}}
                    @foreach ($allChildren as $child)
                        <div class="form-check mb-2">
                            @if (in_array($child->id, $registeredChildrenIds))
                                {{-- Anak yang sudah terdaftar: tidak dapat dipilih --}}
                                <input type="checkbox" disabled class="form-check-input">
                                <label for="child-{{ $child->id }}" class="form-check-label text-muted">
                                    {{ $child->firstname }} {{ $child->lastname }} (Sudah Terdaftar)
                                </label>
                            @else
                                {{-- Anak yang belum terdaftar: dapat dipilih --}}
                                <input type="checkbox" name="child_ids[]" id="child-{{ $child->id }}" value="{{ $child->id }}" class="form-check-input">
                                <label for="child-{{ $child->id }}" class="form-check-label">
                                    {{ $child->firstname }} {{ $child->lastname }}
                                </label>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            @if (!$unregisteredChildren->isEmpty())
                <button type="button" class="btn btn-primary" id="confirm-button">Daftar Anak</button>
            @endif
            <a href="{{ route('activities.parent.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </x-card>

    <script>
        document.getElementById('confirm-button').addEventListener('click', function () {
            if (confirm('Apakah Anda yakin? Pendaftaran tidak bisa dibatalkan.')) {
                document.getElementById('registration-form').submit();
            }
        });
    </script>
</x-user>
{{-- form kalau pake midtrans --}}
{{-- <x-user>
    <x-card>
        <x-slot name="header">
            Pendaftaran Kegiatan: {{ $activity->title }}
        </x-slot>

        <form method="POST" action="{{ route('activities.register.children', $activity->id) }}" id="registration-form">
            @csrf
            <div class="mb-3">
                <label for="child_ids" class="form-label">Daftar Anak</label>
                <div class="form-check">
                    @foreach ($allChildren as $child)
                        <div class="form-check mb-2">
                            @if (in_array($child->id, $registeredChildrenIds))
                                <input type="checkbox" disabled class="form-check-input">
                                <label class="form-check-label text-muted">
                                    {{ $child->firstname }} {{ $child->lastname }} (Sudah Terdaftar)
                                </label>
                            @else
                                <input type="checkbox" name="child_ids[]" value="{{ $child->id }}" class="form-check-input">
                                <label class="form-check-label">
                                    {{ $child->firstname }} {{ $child->lastname }}
                                </label>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            @if (!$unregisteredChildren->isEmpty())
                <button type="button" class="btn btn-primary" id="confirm-button">Daftar Anak</button>
            @endif
            <button type="button" id="show-payment-button" class="btn btn-warning mt-2 mb-2" style="display: none;">
                Tampilkan Pembayaran
            </button>

            <a href="{{ route('activities.parent.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </x-card>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script>
        document.getElementById('confirm-button').addEventListener('click', function () {
            if (confirm('Apakah Anda yakin ingin mendaftarkan anak?')) {
                const selectedChildren = Array.from(document.querySelectorAll('input[name="child_ids[]"]:checked'))
                    .map(input => input.value);

                if (selectedChildren.length === 0) {
                    alert('Pilih minimal satu anak untuk didaftarkan.');
                    return;
                }

                fetch("{{ route('activities.register.children', $activity->id) }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ child_ids: selectedChildren })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.snap_token) {
                        localStorage.setItem('snap_token', data.snap_token);
                        document.getElementById('confirm-button').disabled = true;
                        document.querySelectorAll('input[name="child_ids[]"]').forEach(input => {
                            input.disabled = true;
                        });
                        snap.pay(data.snap_token, {
                            onSuccess: function(result) {
                                alert("Pendaftaran berhasil!");
                                localStorage.removeItem('snap_token');
                                window.location.reload();
                            },
                            onPending: function(result) {
                                alert("Menunggu pembayaran.");
                            },
                            onError: function(result) {
                                alert("Pembayaran gagal.");
                            },
                            onClose: function() {
                                alert("Snap ditutup. Anda dapat membuka kembali pembayaran.");
                                document.getElementById('show-payment-button').style.display = 'block';
                            }
                        });
                    } else if (data.error) {
                        alert(data.error);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                });
            }
        });
        document.addEventListener('DOMContentLoaded', function () {
            const snapToken = localStorage.getItem('snap_token');
            if (snapToken) {
                document.getElementById('confirm-button').disabled = true;
                document.querySelectorAll('input[name="child_ids[]"]').forEach(input => {
                    input.disabled = true;
                });
                document.getElementById('show-payment-button').style.display = 'block';
            }
        });
        document.getElementById('show-payment-button').addEventListener('click', function () {
            const snapToken = localStorage.getItem('snap_token');
            if (snapToken) {
                snap.pay(snapToken, {
                    onSuccess: function(result) {
                        alert("Pendaftaran berhasil!");
                        localStorage.removeItem('snap_token');
                        window.location.reload();
                    },
                    onPending: function(result) {
                        alert("Menunggu pembayaran.");
                    },
                    onError: function(result) {
                        alert("Pembayaran gagal.");
                    },
                    onClose: function() {
                        alert("Snap ditutup. Anda dapat membuka kembali pembayaran.");
                    }
                });
            }
        });
    </script>
</x-user> --}}