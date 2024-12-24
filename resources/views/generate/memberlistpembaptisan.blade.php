<x-app-layout>
    <style>
        .badge-custom {
            font-size: 0.95rem;
            font-weight: bold;
        }
    </style>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <x-card>
        <x-slot name="header">
            List Peserta Pembaptisan - Tanggal: {{ $classDetail->date }}
        </x-slot>

        <table class="table table-responsive-md mb-0">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama Depan</th>
                    <th>Nama Belakang</th>
                    <th>Sertifikat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($classDetail->memberBaptists as $index => $memberBaptist)
                    <tr class="text-center">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $memberBaptist->member->firstname ?? '-' }}</td>
                        <td>{{ $memberBaptist->member->lastname ?? '-' }}</td>
                        <td>
                            @php
                                $attendanceStatus = $classDetail->attendances->firstWhere('id_member', $memberBaptist->member->id);
                            @endphp
                            @if ($attendanceStatus && $attendanceStatus->certificate_url)
                                <!-- Tombol Download Sertifikat -->
                                <a href="{{ route('download.certificatepembaptisan', $attendanceStatus->id) }}" target="_blank" class="btn btn-success">
                                    Lihat Sertifikat
                                </a>
                            @else
                                <span class="badge badge-warning badge-custom text-white">Belum Digenerate</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4"class="text-center">Belum ada peserta yang terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="text-right mt-3">
            <!-- Tombol Generate Sertifikat -->
            <form action="{{ route('generate.certificatepembaptisan', encrypt($classDetail->id)) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-primary">
                    Generate Sertifikat
                </button>
            </form>
            <a href="{{ route('baptist.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </x-card>
</x-app-layout>