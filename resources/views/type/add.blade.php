<x-app-layout>
    <form action="{{ route('type.store') }}" class="form-horizontal form-bordered" method="POST">
        @csrf
        <section class="card">
            <header class="card-header">   
                <h2 class="card-title">Tambah Tipe Jadwal</h2>
            </header>
            <div class="card-body">

                    <x-input-text name="name" id="inputnama" label="Nama" placeholder="Masukan nama tipe jadwal" :required="true"/>

                    <x-input-area name="description" id="inputdeskripsi" label="Deskripsi" placeholder="Masukan deskripsi tipe jadwal" :required="true"/>

            </div>

            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{{ route ('type.index()') }}" class="btn btn-success">Kembali</a>
            </footer>

        </section>
    </form>
</x-app-layout>