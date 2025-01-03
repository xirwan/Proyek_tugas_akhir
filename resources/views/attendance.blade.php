<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <x-card>
        <x-slot name="header">
            List Jadwal
        </x-slot>
        <form method="GET" action="{{ route('attendance.admin') }}" class="mb-4">
            <div class="row">
                <div class="col-lg-4">
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-lg-4">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('attendance.admin') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
        <table class="table table-responsive-md mb-0">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Hari</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Tipe</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                    <th>Deskripsi</th>
                    <th>QR Code</th>
                    <th>Absensi Manual</th>
                    <th>Laporan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schedules as $index => $schedule)
                    <tr>
                        <td>{{ $schedules->firstItem() + $index }}</td>
                        <td>{{ $schedule->day }}</td>
                        <td>{{ $schedule->name }}</td>
                        <td>{{ $schedule->category->name }}</td>
                        <td>{{ $schedule->type->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($schedule->start)->format('H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($schedule->end)->format('H:i') }}</td>
                        <td>{{ $schedule->description }}</td>
                        <td class="actions text-center">
                            @if ($schedule->qr_code_path)
                                <!-- Tombol Show QR -->
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#qrModal-{{ $schedule->id }}">
                                    Show QR
                                </button>

                                <!-- Modal QR -->
                                <div class="modal fade" id="qrModal-{{ $schedule->id }}" tabindex="-1" aria-labelledby="qrModalLabel-{{ $schedule->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="qrModalLabel-{{ $schedule->id }}">QR Code Jadwal</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times</button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <img src="{{ asset('storage/' . $schedule->qr_code_path) }}" class="img-fluid" alt="QR Code">
                                            </div>
                                            <div class="modal-footer">
                                                <a href="{{ asset('storage/' . $schedule->qr_code_path) }}" class="btn btn-primary text-white" download>Download QR Code</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- Tombol Generate QR -->
                                <form method="POST" action="{{ route('schedule.qr.generate', $schedule->id) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Generate QR</button>
                                </form>
                            @endif
                        </td>
                        <td class="actions text-center">
                            <!-- Tombol Absensi Manual -->
                            <a href="{{ route('attendance.adminmanual', $schedule->id) }}" class="btn btn-warning btn-sm text-white">Absensi Manual</a>
                        </td>
                        <td class="actions text-center">
                            <a href="{{ route('attendance.report.form', $schedule->id) }}" class="btn btn-success btn-sm text-white">Laporan</a>
                        </td>
                    </tr>
                @empty
                    <div class="alert alert-danger">
                        Data Jadwal belum tersedia.
                    </div>
                @endforelse
            </tbody>
        </table>
        <div class="mt-5">
            {{ $schedules->links() }}
        </div>
    </x-card>
</x-app-layout>