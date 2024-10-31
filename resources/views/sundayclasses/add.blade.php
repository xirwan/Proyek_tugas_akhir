<x-app-layout>
    <form method="POST" action="{{ route('sunday-classes.store') }}">
        @csrf
        <section class="card">
            <header class="card-header">   
                <h2 class="card-title">Tambah Kelas Sekolah Minggu</h2>
            </header>
            <div class="card-body">                
                <div class="row form-group d-flex justify-content-center align-items-center">
                    <div class="col-lg-9">
                        <x-input-text name="name" id="inputnama" label="Nama kelas sekolah minggu" placeholder="Masukan nama kelas sekolah minggu" :required="true" :errorMessage="$errors->first('name')"/>
                        <x-input-area name="description" id="inputdeskripsi" label="Deskripsi" placeholder="Masukan deskripsi" :required="true"/> 
                    </div>
                </div>
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{{ url()->previous() }}" class="btn btn-success">Kembali</a>
            </footer>
        </section>
    </form>
</x-app-layout>