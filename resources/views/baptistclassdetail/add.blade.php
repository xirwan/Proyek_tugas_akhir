<x-app-layout>
    @if ($errors->any())
        <div id="alert" class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif  
    <form action="{{ route('baptist-class-detail.store', encrypt($baptistclass->id)) }}" class="form-horizontal form-bordered" method="POST">
        @csrf
        <section class="card">
            <header class="card-header">
                <h2 class="card-title">Buat Detail Pertemuan Kelas Pembaptisan</h2>
            </header>
            <div class="card-body">
                <!-- Tampilkan informasi tentang Kelas Pembaptisan -->
                <div class="form-group">
                    <label for="baptist_class_info">Kelas Pembaptisan:</label>
                    <p id="baptist_class_info"><strong>{{ $baptistclass->baptist->date }}</strong> - Hari: <strong>{{ $baptistclass->day }}</strong></p>
                </div>

                <!-- Input Tanggal Mulai -->
                <x-date-picker 
                    name="start_date" 
                    label="Tanggal Mulai" 
                    :required="true" 
                    placeholder="Pilih Tanggal Mulai" 
                />

                <!-- Input Jumlah Pertemuan -->
                <x-input-number 
                label="Jumlah Pertemuan" 
                name="number_of_sessions" 
                placeholder="Masukkan jumlah pertemuan" 
                :required="true" 
                :min="1" 
                :step="1" 
                errorMessage="{{ $errors->first('number_of_sessions') }}"
                />


                <!-- Deskripsi -->
                <x-input-area 
                    name="description" 
                    id="inputdeskripsi" 
                    label="Deskripsi" 
                    placeholder="Masukkan deskripsi untuk pertemuan" 
                    :required="false" 
                />
            </div>
            <footer class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{{ url()->previous() }}" class="btn btn-success">Kembali</a>
            </footer>
        </section>
    </form>
</x-app-layout>