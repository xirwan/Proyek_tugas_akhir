<x-app-layout>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <x-card>
        <x-slot name="header">
            List Anggota
        </x-slot>
        
        <a href= "{{ route('member.create') }}" class="btn btn-md btn-success mb-3">Tambah Anggota</a>

        <table class="table table-responsive mb-0">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama depan</th>
                    <th>Nama belakang</th>
                    <th>Tanggal lahir</th>
                    <th>Alamat</th>
                    <th>Email</th>
                    <th>Cabang</th>
                    <th>Role</th>
                    <th>Posisi</th>
                    <th>Status</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $index => $member)
                    <tr>
                        <td>{{ $members->firstItem() + $index }}</td>
                        <td>{{ $member->firstname }}</td>
                        <td>{{ $member->lastname }}</td>
                        <td>{{ $member->dateofbirth }}</td>
                        <td>{{ $member->user->email }}</td>
                        <td>{{ $member->branch->name }}</td>
                        <td>{{ $member->role->name }}</td>
                        <td>{{ $member->position->name }}</td>
                        <td>{{ $member->status }}</td>
                        <td>{{ $member->address }}</td>
                        <td class="actions text-center">
                            <a href="{{ route('member.show', encrypt($member->id)) }}"><i class="el el-info-circle"></i></a>
                        </td>
                    </tr>
                @empty
                <div class="alert alert-danger">
                    Data Anggota belum tersedia.
                </div>
                @endforelse
            </tbody>
        </table>
        <div class="mt-5">
            {{ $members->links() }}
        </div>
    </x-card>   
</x-app-layout>