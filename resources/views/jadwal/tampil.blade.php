<x-app-layout>
    <section class="card">
        <header class="card-header">   
            <h2 class="card-title">Detail Jadwal</h2>
        </header>
        <form action="{{ route('jadwal.update', encrypt($jadwal->id)) }}" class="form-horizontal form-bordered" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">

                <x-select-box
                name="hari"
                label="Pilih Hari"
                :options="$haripilih"
                :selected="old('hari', $jadwal->hari)" 
                placeholder="Pilih Hari"
                :required="true"
                />

                <x-input-text name="nama" id="inputnama" label="Nama" :value="$jadwal->nama" :required="true"/>

                <x-input-area name="deskripsi" id="inputdeskripsi" label="Deskripsi" :value="$jadwal->deskripsi" :required="true"/>

            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-success">Edit</button>
            </form>
            <form action="{{ route('jadwal.destroy', encrypt($jadwal->id)) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data jadwal ini?');">Hapus</button>
            </form>
                <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
            </footer>
    </section>
</x-app-layout>