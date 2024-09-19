<x-app-layout>
    <form action="{{ route('jadwal.store') }}" class="form-horizontal form-bordered" method="POST">
        @csrf
        <section class="card">
            <header class="card-header">   
                <h2 class="card-title">Tambah Jadwal</h2>
            </header>
            <div class="card-body">

                <x-select-box 
                    name="hari" 
                    label="Pilih Hari" 
                    :options="[
                        'Senin' => 'Senin',
                        'Selasa' => 'Selasa',
                        'Rabu' => 'Rabu',
                        'Kamis' => 'Kamis',
                        'Jumat' => 'Jumat',
                        'Sabtu' => 'Sabtu',
                        'Minggu' => 'Minggu'
                    ]" 
                    placeholder="Pilih Hari" 
                    :selected="old('hari')" 
                    :required="true" 
                />

                <x-input-text name="nama" id="inputnama" label="Nama" placeholder="Masukan nama Ibadah" :required="true"/>

                <x-input-area name="deskripsi" id="inputdeskripsi" label="Deskripsi" placeholder="Masukan deskripsi Ibadah" :required="true"/>

            </div>

            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{{ url()->previous() }}" class="btn btn-success">Kembali</a>
            </footer>

        </section>
    </form>
</x-app-layout>