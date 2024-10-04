<x-app-layout>
    <section class="card">
        <header class="card-header">   
            <h2 class="card-title">Detail Jadwal</h2>
        </header>
        <form action="{{ route('schedule.update', encrypt($schedule->id)) }}" class="form-horizontal form-bordered" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">

                <x-select-box
                name="day"
                label="Pilih Hari"
                :options="$dayoptions"
                :selected="old('day', $schedule->day)" 
                placeholder="Pilih Hari"
                :required="true"
                />

                <x-select-box 
                label="Tipe" 
                name="type_id" 
                :options="$typeoptions" 
                placeholder="Pilih Tipe" 
                :required="true"
                :selected="$schedule->type_id" 
                />

                <x-select-box 
                label="Kategori" 
                name="category_id" 
                :options="$categoryoptions" 
                placeholder="Pilih Kategori" 
                :required="true"
                :selected="$schedule->category_id" 
                />

                <x-input-text name="name" id="inputnama" label="Nama" :value="$schedule->name" :required="true"/>

                <x-input-area name="description" id="inputdeskripsi" label="Deskripsi" :value="$schedule->description" :required="true"/>

                <x-time-picker name="start" label="Jam Mulai" :value="$schedule->start" :required="true" />
                
                <x-time-picker name="end" label="Jam Selesai (optional)" :value="$schedule->end" />

            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-success">Edit</button>
            </form>
            <form action="{{ route('schedule.destroy', encrypt($schedule->id)) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data jadwal ini?');">Hapus</button>
            </form>
                <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
            </footer>
    </section>
</x-app-layout>