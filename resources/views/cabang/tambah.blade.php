<x-app-layout>
    <form action="{{ route('cabang.store') }}" class="form-horizontal form-bordered" method="POST">
        @csrf
        <section class="card">
            <header class="card-header">   
                <h2 class="card-title">Tambah Cabang</h2>
            </header>
            <div class="card-body">

                    <x-input-text name="nama" id="inputnama" label="Nama" placeholder="Masukan nama cabang" :required="true"/>

                    <x-input-area name="alamat" id="inputalamat" label="Alamat" placeholder="Masukan alamat cabang" :required="true"/>

                    <x-radio name="status" label="Status" :options="['Aktif' => 'Aktif', 'Tidak Aktif' => 'Tidak Aktif']" :required="true"/>

            </div>

            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-default">Reset</button>
            </footer>

        </section>
    </form>
</x-app-layout>