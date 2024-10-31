<x-app-layout>
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
                        <th>Aksi</th>
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
                                    <img src="{{ asset('storage/' . $child->qr_code) }}" alt="QR Code {{ $child->firstname }}" class="img-fluid mb-2" style="max-width: 150px;">
                                @else
                                    <a href="{{ route('qr-code.children.generate.qr', $child->id) }}" class="btn btn-success">
                                        Generate QR Code
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if ($child->qr_code)
                                    <a href="{{ asset('storage/' . $child->qr_code) }}" 
                                        download="QR_{{ $child->firstname }}.png" 
                                        class="btn btn-primary mt-2">
                                        Download PNG
                                    </a>
                                @else
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