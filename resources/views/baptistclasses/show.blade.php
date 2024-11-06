<x-app-layout>
    <section class="card">
        <header class="card-header">   
            <h2 class="card-title">Detail Kelas Pembaptisan</h2>
        </header>
        <form action="{{ route('baptist-classes.update', encrypt($baptistclass->id)) }}" class="form-horizontal form-bordered" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <x-select-box 
                label="Tanggal Baptis" 
                name="id_baptist" 
                :options="$baptistoptions" 
                placeholder="Pilih Tanggal Baptis" 
                :required="true"
                :selected="$baptistclass->id_baptist" 
                />
                <x-select-box
                name="day"
                label="Pilih Hari"
                :options="$dayoptions"
                :selected="old('day', $baptistclass->day)" 
                placeholder="Pilih Hari"
                :required="true"
                />
                <x-input-area name="description" id="inputdeskripsi" label="Deskripsi" :value="$baptistclass->description" :required="false"/>
                <x-time-picker name="start" label="Jam Mulai" :value="$baptistclass->start" :required="true" />
                <x-time-picker name="end" label="Jam Selesai" :value="$baptistclass->end" :required="true" />
                <x-radio name="status" label="Status" :options="['Active' => 'Active', 'Inactive' => 'Inactive']" :value="$baptistclass->status" :required="true"/>
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-success">Edit</button>
                <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
            </footer>
        </form>
    </section>
</x-app-layout>