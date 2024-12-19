<x-app-layout>
    <form method="POST" action="{{ route('sunday-classes.store') }}">
        @csrf
        <section class="card">
            <header class="card-header">   
                <h2 class="card-title">Tambah Kelas Sekolah Minggu</h2>
            </header>
            <div class="card-body">
                 <!-- Dropdown untuk memilih jadwal -->
                 <x-select-box 
                 label="Pilih Jadwal" 
                 name="schedule_id" 
                 :options="$schedules->mapWithKeys(function($schedule) {
                     $endTime = $schedule->end ? $schedule->end : '-';
                     return [$schedule->id => $schedule->name . ' - ' . $schedule->day . ' (' . $schedule->start . ' - ' . $endTime . ')'];
                 })" 
                 placeholder="Pilih Jadwal" 
                 :required="true" 
                 />                
                <div class="row form-group">
                    <div class="col-lg-6">
                        <x-input-text name="name" id="inputnama" label="Nama kelas sekolah minggu" placeholder="Masukan nama kelas sekolah minggu" :required="true" :errorMessage="$errors->first('name')"/>
                    </div>
                    <div class="col-lg-6">
                        <x-input-area name="description" id="inputdeskripsi" label="Deskripsi" placeholder="Masukan deskripsi" :required="true"/>
                    </div>
                </div>
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{{ route ('sunday-classes.index') }}" class="btn btn-success">Kembali</a>
            </footer>
        </section>
    </form>
</x-app-layout>