<x-app-layout>
    @if ($errors->any())
    <div id="alert" class="alert alert-danger">
            @foreach ($errors->all() as $error)
                Nama role sudah ada
            @endforeach
    </div>
    @endif
    <form action="{{ route('role.store') }}" class="form-horizontal form-bordered" method="POST">
        @csrf
        <section class="card">
            <header class="card-header">   
                <h2 class="card-title">Tambah Role</h2>
            </header>
            <div class="card-body">

                <x-input-text name="nama" id="inputnama" label="Nama" placeholder="Masukan nama role" :required="true"/>

            </div>

            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-default">Reset</button>
            </footer>

        </section>
    </form>
</x-app-layout>