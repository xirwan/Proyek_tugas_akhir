<x-app-layout>
    <form action="{{ route('category.store') }}" class="form-horizontal form-bordered" method="POST">
        @csrf
        <section class="card">
            <header class="card-header">   
                <h2 class="card-title">Tambah Kategori Jadwal</h2>
            </header>
            <div class="card-body">
                    <x-input-text name="name" id="inputnama" label="Nama" placeholder="Masukan nama kategori jadwal" :required="true"/>
                    <x-input-area name="description" id="inputdeskripsi" label="Deskripsi" placeholder="Masukan deskripsi kategori jadwal" :required="true"/>
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{{ route ('category.index') }}" class="btn btn-success">Kembali</a>
            </footer>
        </section>
    </form>
</x-app-layout>