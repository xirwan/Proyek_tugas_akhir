<x-app-layout>
    <!-- Notifikasi Error -->
    @if ($errors->any())
        <div id="alert" class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif
    <form action="{{ route('news-categories.store') }}" class="form-horizontal form-bordered" method="POST">
        @csrf
        <section class="card">
            <header class="card-header">   
                <h2 class="card-title">Tambah Kategori Berita</h2>
            </header>
            <div class="card-body">
                    <x-input-text name="name" id="inputnama" label="Nama" placeholder="Masukan nama kategori berita" :required="true"/>
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{{ url()->previous() }}" class="btn btn-success">Kembali</a>
            </footer>
        </section>
    </form>
</x-app-layout>