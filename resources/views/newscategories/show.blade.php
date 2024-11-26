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
        <form action="{{ route('news-categories.update', $newscategory->slug) }}" class="form-horizontal form-bordered" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                    <x-input-text name="name" id="inputnama" label="Nama" :value="$newscategory->name" :required="true"/>
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-success">Edit</button>
            </form>
            <form action="{{ route('news-categories.destroy', $newscategory->slug) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data kategori berita ini?');">Hapus</button>
            </form>
                <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
            </footer>
    </section>
</x-app-layout>