<x-app-layout>
    <form action="{{ route('schedule.store') }}" class="form-horizontal form-bordered" method="POST">
        @csrf
        <section class="card">
            <header class="card-header">   
                <h2 class="card-title">Tambah Jadwal</h2>
            </header>
            <div class="card-body">
                <div class="row form-group">
                    <div class="col-lg-4">
                        <x-select-box label="Tipe" name="type_id" :options="$typeoptions" placeholder="Pilih Tipe" :required="true" :selected="old('type_id')" />
                    </div>
                    <div class="col-lg-4">
                        <x-select-box label="Kategori" name="category_id" :options="$categoryoptions" placeholder="Pilih Kategori" :required="true" :selected="old('category_id')" />
                    </div>
                    <div class="col-lg-4">
                        <x-select-box name="day" label="Pilih Hari" 
                                :options="[
                                'Senin' => 'Senin',
                                'Selasa' => 'Selasa',
                                'Rabu' => 'Rabu',
                                'Kamis' => 'Kamis',
                                'Jumat' => 'Jumat',
                                'Sabtu' => 'Sabtu',
                                'Minggu' => 'Minggu'
                                ]" placeholder="Pilih Hari" :selected="old('day')" :required="true"/>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-6">
                        <x-input-text name="name" id="inputnama" label="Nama" placeholder="Masukan nama Ibadah" :required="true"/>
                    </div>
                    <div class="col-lg-6">
                        <x-input-area name="description" id="inputdeskripsi" label="Deskripsi" placeholder="Masukan deskripsi Ibadah" :required="true"/>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-6">
                        <x-time-picker name="start" label="Jam Mulai" :required="true" />
                    </div>
                    <div class="col-lg-6">
                        <x-time-picker name="end" label="Jam Selesai" :required="true" />
                    </div>
                </div>                
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{{ route ('schedule.index') }}" class="btn btn-success">Kembali</a>
            </footer>
        </section>
    </form>
</x-app-layout>