<x-app-layout>
    <section class="card">
        <header class="card-header">   
            <h2 class="card-title">Detail Posisi</h2>
        </header>
        <form action="{{ route('posisi.update', encrypt($positions->id)) }}" class="form-horizontal form-bordered" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">

                    <x-input-text name="nama" id="inputnama" label="Nama" :value="$positions->nama" :required="true"/>

                    <x-input-area name="deskripsi" id="inputdeskripsi" label="Deskripsi" :value="$positions->deskripsi" :required="true"/>

                    <x-radio name="status" label="Status" :options="['Aktif' => 'Aktif', 'Tidak Aktif' => 'Tidak Aktif']" :value="$positions->status" :required="true"/>

            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-success">Edit</button>
            </form>
            <form action="{{ route('posisi.destroy', encrypt($positions->id)) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data posisi ini?');">Hapus</button>
            </form>
                <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
            </footer>
    </section>
</x-app-layout>