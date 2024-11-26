<x-app-layout>
    <!-- Notifikasi Error -->
    @if ($errors->any())
        <div id="alert" class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif
    <section class="card">
        <header class="card-header">   
            <h2 class="card-title">Detail Kategori Berita</h2>
        </header>
        <form action="{{ route('news.update', $news->slug) }}" class="form-horizontal form-bordered" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <x-select-box label="Kategori Berita" name="news_category_id" :options="$newscategoryoptions" :selected="$news->news_category_id" placeholder="Pilih Kategori Berita" :required="true"/>
                <x-input-text name="title" id="inputjudul" placeholder="Masukan judul berita" label="Judul" :value="$news->title" :required="true"/>
                <x-input-area name="content" id="inputkonten" label="Konten Berita" placeholder="Masukan konten berita" :value="$news->content" :required="true"/>
                <x-radio name="status" label="Status" :options="['draft' => 'Draft', 'published' => 'Published']" :value="$news->status" :required="true"/>
                <x-input-file name="image" label="Update Poster (Opsional Max: 2 MB)" accept=".jpeg,.gif,.jpg,.png" :required="false"/>
                <!-- Input File -->
                <!-- Tampilkan gambar yang sudah ada -->
                @if ($news->image)
                    <div class="mt-3">
                        <p>Gambar Saat Ini:</p>
                        <img src="{{ asset('storage/' . $news->image) }}" alt="Gambar {{ $news->title }}" class="img-fluid" style="max-width: 300px;">
                    </div>
                @endif
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-success">Edit</button>
            </form>
            <form action="{{ route('news.destroy', $news->slug) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data kategori berita ini?');">Hapus</button>
            </form>
                <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
            </footer>
    </section>
</x-app-layout>