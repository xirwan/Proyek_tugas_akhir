<x-app-layout>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <x-card>
        <x-slot name="header">
            List Kategori Berita
        </x-slot>
        
        <a href="{{ route('news-categories.create') }}" class="btn btn-md btn-success mb-3">Tambah Kategori Berita</a>

        <table class="table table-responsive-md mb-0">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama</th>
                    <th>Slug</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($newscategories as $index => $newscategory)
                    <tr>
                        <td>{{ $newscategories->firstItem() + $index }}</td>
                        <td>{{ $newscategory->name }}</td>
                        <td>{{ $newscategory->slug }}</td>
                        <td class="actions text-center">
                            <a href="{{ route('news-categories.edit', $newscategory->slug) }}"><i class="el el-info-circle"></i></a>
                        </td>
                    </tr>
                @empty
                <div class="alert alert-danger">
                    Data Kategori Berita belum tersedia.
                </div>
                @endforelse
            </tbody>
        </table>
        <div class="mt-5">
            {{ $newscategories->links() }}
        </div>
    </x-card>
</x-app-layout>