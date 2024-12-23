<x-app-layout>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div id="alert" class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <x-card>
        <x-slot name="header">
            List Pengajuan Anggota Tetap
        </x-slot>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead class="text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Depan</th>
                        <th>Nama Belakang</th>
                        <th>Sertifikat Seminar</th>
                        <th>Sertifikat Baptis</th>
                        <th>Status Seminar</th>
                        <th>Status Baptis</th>
                        <th>Alasan Penolakan</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($certifications as $index => $certification)
                        <tr class="text-center">
                            <td>{{ $certifications->firstItem() + $index }}</td>
                            <td>{{ $certification->member->firstname }}</td>
                            <td>{{ $certification->member->lastname }}</td>
                            <td>
                                @if($certification->seminar_file)
                                    <a href="{{ Storage::url($certification->seminar_file) }}" target="_blank">
                                        Lihat File
                                    </a>
                                @else
                                    <span class="text-danger">Tidak Ada File</span>
                                @endif
                            </td>
                            <td>
                                @if($certification->baptism_file)
                                    <a href="{{ Storage::url($certification->baptism_file) }}" target="_blank">Lihat File</a>
                                @else
                                    <span class="text-danger">Tidak Ada File</span>
                                @endif
                            </td>
                            <td>
                                @if($certification->seminar_certified)
                                    <span class="text-success">Terverifikasi</span>
                                @else
                                    <span class="text-danger">Belum Terverifikasi</span>
                                @endif
                            </td>
                            <td>
                                @if($certification->baptism_certified)
                                    <span class="text-success">Terverifikasi</span>
                                @else
                                    <span class="text-danger">Belum Terverifikasi</span>
                                @endif
                            </td>
                            <td>
                                @if($certification->rejection_reason)
                                    <span class="text-warning">{{ $certification->rejection_reason }}</span>
                                @else
                                    <span class="text-success">-</span>
                                @endif
                            </td>
                            <td class="actions text-center">
                                <a href="{{ route('certifications.show', encrypt($certification->id)) }}">
                                    <i class="el el-info-circle"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">
                                <div class="p-3 mb-2 bg-danger text-white">
                                    Data Sertifikasi belum tersedia.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>    
        <div class="mt-5">
            {{ $certifications->links() }}
        </div>
    </x-card>   
</x-app-layout>