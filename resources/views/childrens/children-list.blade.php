<x-user>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <x-card>
        <x-slot name="header">
            List Anak
        </x-slot>
        <a href="{{ route('member.createChildForm') }}" class="btn btn-md btn-success mb-3">Daftarkan Anak</a>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead class="text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Depan</th>
                        <th>Nama Belakang</th>
                        <th>Tanggal Lahir</th>
                        <th>Alamat</th>
                        <th>Cabang</th>
                        <th>Kelas</th>
                        <th>Status Akun</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($children as $index => $child)
                        <tr class="text-center">
                            <td>{{ $children->firstItem() + $index }}</td>
                            <td>{{ $child->relatedMember->firstname }}</td>
                            <td>{{ $child->relatedMember->lastname }}</td>
                            <td>{{ $child->relatedMember->dateofbirth }}</td>
                            <td>{{ $child->relatedMember->address }}</td>
                            <td>{{ $child->relatedMember->branch->name }}</td>
                            <td>
                                @if($child->relatedMember->sundaySchoolClasses->isNotEmpty())
                                    {{ $child->relatedMember->sundaySchoolClasses->first()->name }}
                                @else
                                    <span class="text-danger">Tidak ada kelas</span>
                                @endif
                            </td>
                            <td>
                                @if($child->relatedMember->user_id)
                                    <span class="text-success">Sudah memiliki akun</span>
                                @else
                                    <span class="text-danger">Belum memiliki akun</span>
                                @endif
                            </td>
                            <td>
                                @if(!$child->relatedMember->user_id)
                                    <a href="{{ route('member.createChildAccount', encrypt($child->relatedMember->id)) }}" class="btn btn-sm btn-primary">
                                        Buatkan Akun
                                    </a>
                                @else
                                    <span class="text-muted">Akun sudah ada</span>
                                @endif
                                <a href="{{ route('member.editChild', $child->relatedMember->id) }}" class="btn btn-sm btn-primary mt-3">
                                    Edit Data
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">
                                <div class="alert alert-danger mb-0">
                                    Anda belum mendaftarkan anak.
                                </div>
                                <a href="{{ route('member.createChildForm') }}" class="btn btn-primary mt-2">
                                    Daftarkan Anak
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-5">
            {{ $children->links() }}
        </div>
    </x-card>    
</x-user>