<x-app-layout>
    <form action="{{ route('baptist-classes.store') }}" class="form-horizontal form-bordered" method="POST">
        @csrf
        <section class="card">
            <header class="card-header">   
                <h2 class="card-title">Tambah Kelas Pembaptisan</h2>
            </header>
            <div class="card-body">
                <x-select-box 
                label="Tanggal Baptis" 
                name="id_baptist" 
                :options="$baptistoptions" 
                placeholder="Pilih Tanggal Baptis" 
                :required="true"
                :selected="old('id_baptist')" 
                />
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
                <x-input-area name="description" id="inputdeskripsi" label="Deskripsi" placeholder="Masukan deskripsi Kelas Pembaptisan" :required="false"/>
                
                <x-time-picker name="start" label="Jam Mulai" :required="true" />
                <x-time-picker name="end" label="Jam Selesai" :required="true"/>
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{{ url()->previous() }}" class="btn btn-success">Kembali</a>
            </footer>
        </section>
    </form>
</x-app-layout>