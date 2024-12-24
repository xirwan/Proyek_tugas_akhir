<x-user>
    <x-card>
        <x-slot name="header">
            Pendaftaran Kegiatan: {{ $activity->title }}
        </x-slot>

        <form method="POST" action="{{ route('activities.registerfree.children', $activity->id) }}" id="registration-form">
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