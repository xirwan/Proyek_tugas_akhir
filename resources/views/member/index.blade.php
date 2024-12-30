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
        <form method="GET" action="{{ route('member.index') }}" class="mb-4">
            <div class="row">
                <div class="col-lg-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama atau email" value="{{ request('search') }}">
                </div>
                <div class="col-lg-4">
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-lg-4">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('member.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
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
                        {{-- <th>Role</th> --}}
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
                            {{-- <td>
                                @if($member->user && $member->user->roles->isNotEmpty())
                                    {{ $member->user->roles->pluck('name')->join(', ') }}
                                @else
                                    <span class="text-danger">Belum memiliki akun</span>
                                @endif
                            </td> --}}
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
                        <div class="alert alert-danger">
                            Data Anggota belum tersedia.
                        </div>
                    @endforelse
                </tbody>
            </table>
        </div>    
        <div class="mt-5">
            {{ $members->withQueryString()->links() }}
        </div>
    </x-card>   
</x-app-layout>