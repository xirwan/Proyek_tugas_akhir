<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @if (session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <x-card>
        <x-slot name="header">
            List Jadwal
        </x-slot>
        <a href="{{ route('news.create') }}" class="btn btn-md btn-success mb-3">Tambah Berita</a>
        <table class="table table-responsive-md mb-0">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Judul</th>
                    <th>Kategori Berita</th>
                    <th>Poster</th>
                    <th>Status</th>
                    <th>Slug</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($news as $index => $itemnews)
                    <tr>
                        <td>{{ $news->firstItem() + $index }}</td>
                        <td>{{ $itemnews->title }}</td>
                        <td>{{ $itemnews->newscategory->name }}</td>
                        <td>
                            @if ($itemnews->image)
                                <button class="btn btn-primary btn-show-image" data-bs-toggle="modal" data-bs-target="#imageModal{{ $itemnews->id }}">
                                    Show Image
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="imageModal{{ $itemnews->id }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $itemnews->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="imageModalLabel{{ $itemnews->id }}">Image for {{ $itemnews->title }}</h5>
                                            </div>
                                            <div class="modal-body text-center">
                                                <img src="{{ asset('storage/' . $itemnews->image) }}" alt="Image for {{ $itemnews->title }}" class="img-fluid" style="max-width: 300px;">
                                            </div>
                                            <div class="modal-footer">
                                                <a href="{{ asset('storage/' . $itemnews->image) }}" 
                                                    download="Image_{{ $itemnews->title }}.png" 
                                                    class="btn btn-primary">
                                                    Download Poster
                                                </a>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <span class="text-danger">Gambar tidak ada</span>
                            @endif
                        </td>
                        <td>{{ $itemnews->status }}</td>
                        <td>{{ $itemnews->slug }}</td>
                        <td class="actions text-center">
                            <a href="{{ route('news.edit', $itemnews->slug) }}"><i class="el el-info-circle"></i></a>
                        </td>
                    </tr>
                @empty
                    <div class="alert alert-danger">
                        Data Berita belum tersedia.
                    </div>
                @endforelse
            </tbody>
        </table>
        <div class="mt-5">
            {{ $news->links() }}
        </div>
    </x-card>
</x-app-layout>