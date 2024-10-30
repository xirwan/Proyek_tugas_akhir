<x-app-layout>
    <form action="{{ route('schedule.store') }}" class="form-horizontal form-bordered" method="POST">
        @csrf
        <section class="card">
            <header class="card-header">   
                <h2 class="card-title">Tambah Jadwal</h2>
            </header>
            <div class="card-body">
                <x-select-box 
                    name="day" 
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
                    :selected="old('day')" 
                    :required="true" 
                />
                <x-input-text name="name" id="inputnama" label="Nama" placeholder="Masukan nama Ibadah" :required="true"/>
                <x-input-area name="description" id="inputdeskripsi" label="Deskripsi" placeholder="Masukan deskripsi Ibadah" :required="true"/>
                <x-select-box 
                label="Tipe" 
                name="type_id" 
                :options="$typeoptions" 
                placeholder="Pilih Tipe" 
                :required="true"
                :selected="old('type_id')" 
                />
                <x-select-box 
                label="Kategori" 
                name="category_id" 
                :options="$categoryoptions" 
                placeholder="Pilih Kategori" 
                :required="true"
                :selected="old('category_id')" 
                />
                <x-time-picker name="start" label="Jam Mulai" :required="true" />
                <x-time-picker name="end" label="Jam Selesai (optional)" />
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{{ url()->previous() }}" class="btn btn-success">Kembali</a>
            </footer>
        </section>
    </form>
</x-app-layout>