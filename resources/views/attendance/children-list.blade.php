<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <x-card>
        <x-slot name="header">
            List Anak Sekolah Minggu
        </x-slot>
        <a href="{{ route('qr-code.generate.all.qr') }}" class="btn btn-md btn-success mb-3">Generate QR Code untuk Semua Anak Tanpa QR</a>
        <!-- Tombol Tambah Data Anak -->
        <a href="{{ route('admin.addChild') }}" class="btn btn-md btn-primary mb-3">Tambah Data Anak</a>
        <form method="GET" action="{{ route('qr-code.children.list') }}" class="mb-4">
            <div class="row">
                <div class="col-lg-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama" value="{{ request('search') }}">
                </div>
                <div class="col-lg-4">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="{{ route('qr-code.children.list') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
        <div class="table-responsive text-center">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Tanggal Lahir</th>
                        <th>Kelas</th>
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
                                @if($child->sundaySchoolClasses->isNotEmpty())
                                    {{ $child->sundaySchoolClasses->first()->name }}
                                @else
                                    <span class="text-danger">Tidak ada kelas</span>
                                @endif
                            </td>
                            <td class="text-center">
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
                                                    <a href="{{ route('qr-code.children.generate.nametag', $child->id) }}" target="_blank" class="btn btn-success">
                                                        Generate Name Tag
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
                            <td class="text-center">
                                <a href="{{ route('sundayschoolclass.showAdjustClassForm', encrypt($child->id)) }}" class="btn btn-sm btn-primary">
                                    Sesuaikan Kelas
                                </a>
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
