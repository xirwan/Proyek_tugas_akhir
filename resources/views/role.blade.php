<x-app-layout>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <x-card>
        <x-slot name="header">
            List Role
        </x-slot>
        
        <a href="{{ route('role.create') }}" class="btn btn-md btn-success mb-3">Tambah Role</a>

        <table class="table table-responsive-md mb-0">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama role</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $index => $role)
                    <tr>
                        <td>{{ $roles->firstItem() + $index }}</td>
                        <td>{{ $role->name }}</td>
                        <td class="actions text-center">
                            <a href="{{ route('role.show', encrypt($role->id)) }}"><i class="el el-info-circle"></i></a>
                        </td>
                    </tr>
                @empty
                <div class="alert alert-danger">
                    Data Role belum tersedia.
                </div>
                @endforelse
            </tbody>
        </table>
        <div class="mt-5">
            {{ $roles->links() }}
        </div>
    </x-card>
</x-app-layout>