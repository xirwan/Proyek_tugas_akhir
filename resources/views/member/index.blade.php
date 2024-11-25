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
        <div class="table-responsive">
            <table class="table mb-0">
                <thead class="text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Depan</th>
                        <th>Nama Belakang</th>
                        <th>Tanggal Lahir</th>
                        <th>Email</th>
                        <th>Cabang</th>
                        <th>Role</th>
                        <th>Posisi</th>
                        <th>Status</th>
                        <th>Alamat</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $index => $member)
                        <tr class="text-center">
                            <td>{{ $members->firstItem() + $index }}</td>
                            <td>{{ $member->firstname }}</td>
                            <td>{{ $member->lastname }}</td>
                            <td>{{ $member->dateofbirth }}</td>
                            <td>{{ optional($member->user)->email ?? '-' }}</td>
                            <td>{{ $member->branch->name }}</td>
                            <td>
                                @if($member->user && $member->user->roles->isNotEmpty())
                                    {{ $member->user->roles->pluck('name')->join(', ') }}
                                @else
                                    <span class="text-danger">Belum memiliki akun</span>
                                @endif
                            </td>
                            <td>{{ $member->position->name }}</td>
                            <td>{{ $member->status }}</td>
                            <td>{{ $member->address }}</td>
                            <td class="actions text-center">
                                <a href="{{ route('member.show', encrypt($member->id)) }}">
                                    <i class="el el-info-circle"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center">
                                <div class="p-3 mb-2 bg-danger text-white">
                                    Data Anggota belum tersedia.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>    
        <div class="mt-5">
            {{ $members->links() }}
        </div>
    </x-card>   
</x-app-layout>