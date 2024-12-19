<x-app-layout>
    @if(session('error'))
        <div id="alert" class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <section class="card">
        <header class="card-header">   
            <h2 class="card-title">Detail Kelas Sekolah Minggu</h2>
        </header>
        <form action="{{ route('sunday-classes.update', encrypt($class->id)) }}" class="form-horizontal form-bordered" method="POST">
            @csrf
            @method('PUT')
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="card-body">
                <div class="row form-group">
                    <div class="col-lg-6">
                        <x-select-box 
                        label="Pilih Jadwal" 
                        name="schedule_id" 
                        :options="$schedules->mapWithKeys(function($schedule) {
                            $endTime = $schedule->end ? $schedule->end : '-';
                            return [$schedule->id => $schedule->name . ' - ' . $schedule->day . ' (' . $schedule->start . ' - ' . $endTime . ')'];
                        })" 
                        placeholder="Pilih Jadwal" 
                        :required="true" 
                        :selected="$class->schedule_id" 
                        />        
                    </div>
                    <div class="col-lg-6">
                        <x-radio name="status" label="Status" :options="['Active' => 'Active', 'Inactive' => 'Inactive']" :value="$class->status" :required="true"/>
                    </div>
                </div>        
                <div class="row form-group">
                    <div class="col-lg-6">
                        <x-input-text name="name" id="inputnama" label="Nama kelas sekolah minggu" placeholder="Masukan nama kelas sekolah minggu" :value="$class->name" :required="true" :errorMessage="$errors->first('name')"/>
                    </div>
                    <div class="col-lg-6">
                        <x-input-area name="description" id="inputdeskripsi" label="Deskripsi" placeholder="Masukan deskripsi" :value="$class->description" :required="true"/>
                    </div>
                </div>
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Edit</button>
            </form>

            <!-- Tombol Nonaktifkan dan Aktifkan -->
            @if($class->status === 'Active')
                <form action="{{ route('sunday-classes.destroy', encrypt($class->id)) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menonaktifkan data kelas sekolah minggu ini?');">
                        Nonaktifkan
                    </button>
                </form>
            @else
                <form action="{{ route('sunday-classes.active', encrypt($class->id)) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-secondary" onclick="return confirm('Apakah Anda yakin ingin mengaktifkan data kelas sekolah minggu ini?');">
                        Aktifkan
                    </button>
                </form>
            @endif

            <a href="{{ route('sunday-classes.index') }}" class="btn btn-success">Kembali</a>
            </footer>
    </section>
</x-app-layout>
