<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <x-card>
        <x-slot name="header">
            List Qr Anak Sekolah Minggu
        </x-slot>
        <a href="{{ route('qr-code.generate.all.qr') }}" class="btn btn-md btn-success mb-3">Generate QR Code untuk Semua Anak Tanpa QR</a>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead class="text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Tanggal Lahir</th>
                        <th>Status QR Code</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($children as $index => $child)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $child->firstname }} {{ $child->lastname }}</td>
                            <td>{{ $child->dateofbirth }}</td>
                            <td>
                                @if ($child->qr_code)
                                    <button class="btn btn-primary btn-show-qr" data-bs-toggle="modal" data-bs-target="#qrModal{{ $child->id }}">
                                        Show QR
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="qrModal{{ $child->id }}" tabindex="-1" aria-labelledby="qrModalLabel{{ $child->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="qrModalLabel{{ $child->id }}">QR Code for {{ $child->firstname }}</h5>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <img src="{{ asset('storage/' . $child->qr_code) }}" alt="QR Code {{ $child->firstname }}" class="img-fluid" style="max-width: 300px;">
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="{{ asset('storage/' . $child->qr_code) }}" 
                                                        download="QR_{{ $child->firstname }}.png" 
                                                        class="btn btn-primary">
                                                        Download PNG
                                                    </a>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <a href="{{ route('qr-code.children.generate.qr', $child->id) }}" class="btn btn-success">
                                        Generate QR Code
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if (!$child->qr_code)
                                    <span class="text-danger">Belum ada QR Code</span>
                                @endif
                            </td>                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-5">
            {{ $children->links() }}
        </div>
    </x-card>
</x-app-layout>
