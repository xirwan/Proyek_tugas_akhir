<x-app-layout>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <x-card>
        <x-slot name="header">
            List Detail Pertemuan Kelas Pembaptisan
        </x-slot>

        <table class="table table-responsive-md mb-0">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($classdetails as $index => $classdetail)
                    <tr>
                        <td>{{ $classdetails->firstItem() + $index }}</td>
                        <td>{{ $classdetail->date }}</td>
                        <td>{{ $classdetail->description }}</td>
                        <td>{{ $classdetail->status }}</td>
                        <td class="actions text-center">
                            {{-- <a href="{{ route('baptist-class-detail.show', encrypt($classdetail->id)) }}"><i class="el el-info-circle"></i></a> --}}
                        </td>
                    </tr>
                @empty
                <div class="alert alert-danger">
                    Data Pertemuan Kelas Pembaptisan belum tersedia.
                </div>
                @endforelse
            </tbody>
        </table>
        <div class="mt-5">
            {{ $classdetails->links() }}
        </div>
    </x-card>
</x-app-layout>