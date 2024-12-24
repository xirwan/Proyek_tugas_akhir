<x-app-layout>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <x-card>
        <x-slot name="header">
            Tanggal Pembaptisan {{ $class->baptist->date }}<br><br>
            Daftar Peserta di Kelas {{ $class->day }}
        </x-slot>

        <table class="table table-responsive-md mb-0 text-center">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Tanggal Lahir</th>
                    <th>Alamat</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($class->members as $index => $memberBaptist)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $memberBaptist->member->firstname }} {{ $memberBaptist->member->lastname }}</td>
                        <td>{{ $memberBaptist->member->dateofbirth }}</td>
                        <td>{{ $memberBaptist->member->address }}</td>
                        <td>{{ $memberBaptist->status }}</td>
                        <td>
                            <a href="{{ route('baptist-classes.showAdjustClassForm', encrypt($memberBaptist->id)) }}" class="btn btn-sm btn-primary">
                                Pindahkan Kelas
                            </a>
                        </td>
                    </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada peserta yang terdaftar di kelas ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </x-card>
</x-app-layout>