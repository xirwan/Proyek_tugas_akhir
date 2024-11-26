<x-app-layout>
    <!-- Notifikasi Error -->
    @if ($errors->any())
        <div id="alert" class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif
    <form action="{{ route('news.store') }}" class="form-horizontal form-bordered" method="POST" enctype="multipart/form-data">
        @csrf
        <section class="card">
            <header class="card-header">   
                <h2 class="card-title">Tambah Berita</h2>
            </header>
            <div class="card-body">
                <x-select-box label="Kategori Berita" name="news_category_id" :options="$newscategoryoptions" placeholder="Pilih Kategori Berita" :required="true" :selected="old('news_category_id')"/>
                <x-input-text name="title" id="inputjudul" label="Judul" placeholder="Masukan judul  berita" :required="true"/>
                <x-input-area name="content" id="inputkonten" label="Konten Berita" placeholder="Masukan konten berita" :required="true"/>
                <x-input-file name="image" label="Upload Poster (Opsional Max: 2 MB)" accept=".jpeg,.gif,.jpg,.png" :required="false"/>
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{{ url()->previous() }}" class="btn btn-success">Kembali</a>
            </footer>
        </section>
    </form>
</x-app-layout>