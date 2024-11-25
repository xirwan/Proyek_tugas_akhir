<x-app-layout>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <x-card>
        <x-slot name="header">
            List Laporan Mingguan
        </x-slot>
        
        <a href="{{ route('admin.reports.create') }}" class="btn btn-md btn-success mb-3">Tambah Laporan Mingguan</a>

        <table class="table table-responsive-md mb-0">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Kelas</th>
                    <th>Minggu</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>File</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $index => $report)
                    <tr>
                        <td>{{ $reports->firstItem() + $index }}</td>
                        <td>{{ $report->sundaySchoolClass->name ?? 'Tidak Tersedia' }}</td> <!-- Menampilkan nama kelas -->
                        <td>{{ $report->week_of }}</td>
                        <td>{{ $report->title }}</td>
                        <td>{{ $report->description ?? '-' }}</td>
                        <td>
                            @if ($report->file_path)
                                <a href="{{ route('admin.reports.download', $report->id) }}" class="btn btn-primary">
                                    Download
                                </a>
                            @else
                                <span class="text-muted">Tidak ada file</span>
                            @endif
                        </td>
                        <td class="actions text-center">
                            <form action="{{ route('admin.reports.destroy', $report->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?');">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <div class="p-3 mb-2 bg-danger text-white">
                        Data Laporan belum tersedia.
                    </div>
                @endforelse
            </tbody>
        </table>
        <div class="mt-5">
            {{ $reports->links() }}
        </div>
    </x-card>
</x-app-layout>